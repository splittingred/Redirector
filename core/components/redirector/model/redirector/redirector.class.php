<?php
/**
 * @package redirector
 */
class Redirector {
    /**
     * Constructs the Redirector object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('redirector.core_path',$config,$this->modx->getOption('core_path').'components/redirector/');
        $assetsUrl = $this->modx->getOption('redirector.assets_url',$config,$this->modx->getOption('assets_url').'components/redirector/');
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);


        $this->cacheName = 'Redirector';
        $this->cache = $this->modx->cacheManager->getCacheProvider($this->cacheName, array(
            xPDO::OPT_CACHE_KEY => $this->cacheName
        ));

        $this->modx->addPackage('redirector',$this->config['modelPath']);
    }


    /**
     * Given a search parameter, look in the cache for a match. If none found, look for a matching pattern. If found,
     * redirect. Otherwise do nothing.
     * @param $search
     */
    public function getRedirect($search){
        // Look for a target in the cache
        $redirect = $this->cache->get(md5($search));
        if($redirect){
            $this->doRedirect($redirect, $search, 'Cache');
            exit();
        }

        // No entry  in the cache. Try to match a pattern.

        // Exact text match
        $pattern = $this->modx->getObject('modRedirect', array(
            'pattern' => $search
            ,'active' => 1
        ));
        if($pattern){
            $target = $pattern->get('target');
            $this->doRedirect($target, $search, 'Plain Text');
            exit();
        }

        // No luck ? Check the regexp.
        $query = $this->modx->newQuery('modRedirect');
        $query->where(array('active' => 1, 'isregexp' => 1));
        $query->sortby('sortorder', 'ASC');
        $patterns = $this->modx->getCollection('modRedirect', $query);
        foreach($patterns as $pattern){
            $pat = $pattern->get('pattern');
            if(preg_match("~$pat~", $search)){
                $target = $pattern->get('target');
                $target = preg_replace("~$pat~", $target, preg_replace('/[\[\]]/', '',$search));
                $this->doRedirect($target, $search, 'Regexp');
                exit();
            }
        }
    }

    /**
     * Prepare the new URL and redirect the user (and cache the redirect).
     *
     * @param $target String target recorded in the database
     * @param $search String the search string used
     */
    private function doRedirect($target, $search='', $type='Plain Text'){
        $this->modx->parser->processElementTags('', $target, true, true);
        if ($target != $this->modx->resourceIdentifier && $target != $search) {
            $short_target = $target;
            if (!strpos($target, '://')) {
                $target = $this->modx->getOption('site_url').$target;
            }
            $this->modx->log(modX::LOG_LEVEL_INFO, 'Redirector plugin redirecting request for ' . $search . ' to ' . $target. 'Rule: '.$type);

            // Cache the new redirect
            $this->cache->set(md5($search), $short_target);

            // Perform the redirect.
            header('HTTP/1.1 301 Moved Permanently');
            $this->modx->sendRedirect($target);
            exit();
        }
    }


    public function record404($search){
        $error = $this->modx->getObject('modRedirectPageNotFound', array('url' => $search));
        $now = time();
        if(!empty($error)){ // We've encountered this one before.
            $count = $error->get('times');
            $count += 1;
            $error->set('times', $count);
            $error->set('lasttime', $now);
            $error->save();
        } else {
            $error = $this->modx->newObject('modRedirectPageNotFound');
            $error->set('url', $search);
            $error->set('firsttime', $now);
            $error->set('lasttime', $now);
            $error->set('times', 1);
            $error->set('visible', 1);
            $error->save();
        }
    }


    /**
     * Clear the Redirect cache
     * @access public
     */
    public function clearRedirectCache(){
        $this->modx->cacheManager->refresh(array($this->cacheName => array()));
    }

    /**
     * Initializes the class into the proper context
     *
     * @access public
     * @param string $ctx
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                $this->modx->lexicon->load('redirector:default');

                if (!$this->modx->loadClass('redirector.request.redirectorControllerRequest',$this->config['modelPath'],true,true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new redirectorControllerRequest($this);
                return $this->request->handleRequest();
                break;
            case 'connector':
                if (!$this->modx->loadClass('redirector.request.redirectorConnectorRequest',$this->config['modelPath'],true,true)) {
                    echo 'Could not load connector request handler.'; die();
                }
                $this->request = new redirectorConnectorRequest($this);
                return $this->request->handle();
                break;
            default: break;
        }
        return true;
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }
    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name) {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).'.chunk.tpl';
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}