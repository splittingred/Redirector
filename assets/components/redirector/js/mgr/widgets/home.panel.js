Redi.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('redirector.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,stateful: true
            ,stateId: 'redirector-home-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState:function() {
                return {activeTab:this.items.indexOf(this.getActiveTab())};
            }
            ,items: [{
                title: _('redirector.errors')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('redirector.pnfdesc')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'redirector-grid-pagenotfound'
                    ,preventRender: true
                }]
            },{
                title: _('redirector.redirects')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('redirector.desc')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'redirector-grid-redirects'
                    ,preventRender: true
                }]
            }]
        }]
    });
    Redi.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Redi.panel.Home,MODx.Panel);
Ext.reg('redirector-panel-home',Redi.panel.Home);
