<style>
    
/* 
* Load the core stylesheet inline because the uri system can't be used yet
*/
    
[run tpl=css/base.css/css-rules.tpl]

[run tpl=css/forms.css/css-rules.tpl]

ul.system-requirements, ul.navigation.steps { margin: 0; }

ul.system-requirements li, ul.navigation.steps { list-style-type: none; }

li.pass:before { content: "\2714"; color: green; padding-right: 4px;}

li.fail:before { content: "\2718"; color: red; padding-right: 4px;}

</style>
