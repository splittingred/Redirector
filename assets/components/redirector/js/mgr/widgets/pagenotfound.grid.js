Redi.grid.PageNotFound = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'redirector-grid-pagenotfound'
        ,url: Redi.config.connector_url
        ,baseParams: { action: 'mgr/errors/getList' }
        ,fields: ['id','url','times','firsttime','lasttime','menu']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'url'
        ,columns: [{
            header: _('redirector.url')
            ,dataIndex: 'url'
            ,sortable: false
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.times')
            ,dataIndex: 'times'
            ,sortable: true
            ,width: 40
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.firsttime')
            ,dataIndex: 'firsttime'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.lasttime')
            ,dataIndex: 'lasttime'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar: [{
            xtype: 'textfield'
            ,id: 'redirector-search-filter'
            ,emptyText: _('redirector.search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true; }
                        ,scope: cmp
                    });
                },scope:this}
            }
        }]
    });
    Redi.grid.PageNotFound.superclass.constructor.call(this,config)
};
Ext.extend(Redi.grid.PageNotFound,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,removeRedirectPageNotFound: function() {
        MODx.msg.confirm({
            title: _('redirector.redirect_remove_page_not_found')
            ,text: _('redirector.redirect_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/errors/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });

    }
    ,createRedirectPageNotFound: function(btn,e){
        if (!this.createRedirectPNFWindow) {
            this.createRedirectPNFWindow = MODx.load({
                xtype: 'redirector-window-redirect-create-from-pnf'
                ,record: {
                    pattern : this.menu.record.url.replace(/^\//, '')
                    ,target: ''
                    ,active: 1
                    ,isregexp: 0
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.createRedirectPNFWindow.setValues(this.menu.record);
        this.createRedirectPNFWindow.show(e.target);
    }
});
Ext.reg('redirector-grid-pagenotfound',Redi.grid.PageNotFound);

//
Redi.window.CreateRedirectPageNotFound = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('redirector.redirect_create')
        ,url: Redi.config.connector_url
        ,baseParams: {
            action: 'mgr/redirect/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('redirector.pattern')
            ,name: 'pattern'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('redirector.target')
            ,name: 'target'
            ,width: 300
        },{
            xtype: 'checkbox'
            ,fieldLabel: _('redirector.active')
            ,name: 'active'
            ,inputValue: 1
            ,checked: true
        },{
            xtype: 'checkbox'
            ,fieldLabel: _('redirector.isregexp')
            ,name: 'isregexp'
            ,inputValue: 1
        }]
    });
    Redi.window.CreateRedirectPageNotFound.superclass.constructor.call(this,config);
};
Ext.extend(Redi.window.CreateRedirectPageNotFound,MODx.Window);
Ext.reg('redirector-window-redirect-create-from-pnf',Redi.window.CreateRedirectPageNotFound);