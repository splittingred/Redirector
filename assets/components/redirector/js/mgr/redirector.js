var Redi = function(config) {
    config = config || {};
    Redi.superclass.constructor.call(this,config);
};
Ext.extend(Redi,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('redirector',Redi);

Redi = new Redi();