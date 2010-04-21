Ext.onReady(function() {
    MODx.load({ xtype: 'redirector-page-home'});
});

Redi.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'redirector-panel-home'
            ,renderTo: 'redirector-panel-home-div'
        }]
    });
    Redi.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Redi.page.Home,MODx.Component);
Ext.reg('redirector-page-home',Redi.page.Home);