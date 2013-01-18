Redi.grid.Redirects = function(config) {
    config = config || {};
    var cb = new Ext.ux.grid.CheckColumn({
        header: _('redirector.active')
        ,dataIndex: 'active'
        ,width: 30
        ,sortable: true
        ,onMouseDown: this.saveCheckbox
    });
    var re = new Ext.ux.grid.CheckColumn({
        header: _('redirector.isregexp')
        ,dataIndex: 'isregexp'
        ,width: 30
        ,sortable: true
        ,onMouseDown: this.saveCheckbox
    });

    Ext.applyIf(config,{
        id: 'redirector-grid-redirects'
        ,url: Redi.config.connector_url
        ,baseParams: { action: 'mgr/redirect/getList', limit: 0, start: 0 }
        ,save_action: 'mgr/redirect/updateFromGrid'
        ,fields: ['id','pattern','target','active','isregexp','sortorder','menu']
        ,paging: false
        ,limit: 0
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,enableDragDrop: true
        ,ddGroup: 'redirect-dd'
        ,ddText: 'Yeah ! You\'re dragging me'
        ,plugins: [cb,re]
        ,columns: [{
            header: _('redirector.pattern')
            ,dataIndex: 'pattern'
            ,sortable: true
            ,width: 150
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.target')
            ,dataIndex: 'target'
            ,sortable: false
            ,width: 150
            ,editor: { xtype: 'textfield' }
        },cb,re,
            {
                header: _('redirector.priority')
                ,dataIndex: 'sortorder'
                ,sortable: true
                ,width: 30
                ,editor: { xtype: 'numberfield' }
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
        ,listeners:{
            "render": {
                scope: this,
                fn: function(grid){
                    var ddrow = new Ext.dd.DropTarget(grid.container, {
                        ddGroup : 'redirect-dd',
                        copy:false,
                        notifyDrop : function(dd, e, data){
                            var ds = grid.store;
                            var sm = grid.getSelectionModel();
                            var rows = sm.getSelections();
                            if(dd.getDragData(e)) {
                                var cindex=dd.getDragData(e).rowIndex;
                                if(typeof(cindex) != "undefined") {
                                    for(i = 0; i <  rows.length; i++) {
                                        ds.remove(ds.getById(rows[i].id));
                                    }
                                    ds.insert(cindex,data.selections);
                                    sm.clearSelections();
                                }
                            }
                            grid.collectItems();
                        }
                    });

                    this.setWidth('99%');
                }
            }
        }
    });


    Redi.grid.Redirects.superclass.constructor.call(this,config)
};
Ext.extend(Redi.grid.Redirects,MODx.grid.Grid,{
    collectItems: function(){
        var items=[];
        // read jsons from grid-store-items
        var griddata=this.store.data;
        for(i = 0; i <  griddata.length; i++) {
            items.push(griddata.items[i].json);
        }

        items = Ext.util.JSON.encode(items);
        MODx.Ajax.request({
            url: Redi.config.connector_url
            ,params: {
                action: 'mgr/redirect/sort'
                ,items: items
                ,start: this.start
                ,limit: this.limit
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.refresh();
                },scope:this}
            }
        });
    }
    ,search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,saveCheckbox: function(e, t){
        var rowData = false;
        /* checks/unchecks */
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
            record.set(this.dataIndex, !record.data[this.dataIndex]);
            rowData = record.data; /*save row records. will be used in the ajax request */
        }

        /*don't send the ajax request if the rowData is empty. rowData is empty if the row is clicked. */
        if (!rowData) return;

        /* send ajax request to update the data */
        MODx.Ajax.request({
            url: Redi.config.connector_url
            ,params: {
                action : 'mgr/redirect/updateFromGrid'
                ,data: Ext.util.JSON.encode(rowData)
            }
            ,method: 'POST'
            ,listeners: {
                'success': {fn: function(r) {
                    Ext.getCmp('redirector-grid-redirects').getStore().commitChanges();
                },scope: this}
            }
        });
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
        },{
            xtype: 'checkbox'
            ,fieldLabel: _('redirector.isregexp')
            ,name: 'isregexp'
            ,inputValue: 1
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
        },{
            xtype: 'checkbox'
            ,fieldLabel: _('redirector.isregexp')
            ,name: 'isregexp'
            ,inputValue: 1
        }]
    });
    Redi.window.UpdateRedirect.superclass.constructor.call(this,config);
};
Ext.extend(Redi.window.UpdateRedirect,MODx.Window);
Ext.reg('redirector-window-redirect-update',Redi.window.UpdateRedirect);