Redi.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('redirector.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,stateful: true
            ,stateId: 'redirector-home-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState:function() {
                return {activeTab:this.items.indexOf(this.getActiveTab())};
            }
            ,items: [{
                title: _('redirector.redirects')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: _('redirector.desc')
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'redirector-grid-redirects'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            }]
        }]
    });
    Redi.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Redi.panel.Home,MODx.Panel);
Ext.reg('redirector-panel-home',Redi.panel.Home);
