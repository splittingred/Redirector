Redi.grid.Redirects = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'redirector-grid-redirects'
        ,url: Redi.config.connector_url
        ,baseParams: { action: 'mgr/redirect/getList' }
        ,save_action: 'mgr/redirect/updateFromGrid'
        ,fields: ['id','pattern','target','active','menu']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('redirector.pattern')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 200
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.target')
            ,dataIndex: 'target'
            ,sortable: false
            ,width: 200
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
        },{
            text: _('redirector.redirect_create')
            ,handler: { xtype: 'redirector-window-redirect-create' ,blankValues: true }
        }]
    });
    Redi.grid.Redirects.superclass.constructor.call(this,config)
};
Ext.extend(Redi.grid.Redirects,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,updateRedirect: function(btn,e) {
        if (!this.updateRedirectWindow) {
            this.updateRedirectWindow = MODx.load({
                xtype: 'redirector-window-redirect-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateRedirectWindow.setValues(this.menu.record);
        this.updateRedirectWindow.show(e.target);
    }

    ,removeRedirect: function() {
        MODx.msg.confirm({
            title: _('redirector.redirect_remove')
            ,text: _('redirector.redirect_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/redirect/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('redirector-grid-redirects',Redi.grid.Redirects);


Redi.window.CreateRedirect = function(config) {
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
        }]
    });
    Redi.window.CreateRedirect.superclass.constructor.call(this,config);
};
Ext.extend(Redi.window.CreateRedirect,MODx.Window);
Ext.reg('redirector-window-redirect-create',Redi.window.CreateRedirect);


Redi.window.UpdateRedirect = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('redirector.redirect_update')
        ,url: Redi.config.connector_url
        ,baseParams: {
            action: 'mgr/redirect/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
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
        }]
    });
    Redi.window.UpdateRedirect.superclass.constructor.call(this,config);
};
Ext.extend(Redi.window.UpdateRedirect,MODx.Window);
Ext.reg('redirector-window-redirect-update',Redi.window.UpdateRedirect);