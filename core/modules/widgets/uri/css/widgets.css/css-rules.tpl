/*
 * widgets.css
 */

/*
 * Tabs
 */
 
.tab-content { display: none; }

.tab-content.active { display: block; }

ul.tabs { border-bottom: 1px solid #ddd; display: block; height: 39px; 
    list-style-type: none; margin: 0;}

ul.tabs:after { display: table; line-height: 0; content: ""; }

ul.tabs li { float: left; margin-right: 4px; }

ul.tabs li a { display: block; line-height: 20px; padding: 10px 10px 9px 10px; 
    border-radius: 4px 4px 0px 0px;}
    
ul.tabs li a:hover { background: #ededed; }

ul.tabs li.active a:hover { background: #fff; }    

ul.tabs li.active a { border: 1px solid #ddd; border-bottom: 0; 
    background: white; color: #444; text-decoration: none; cursor: default; } 

/* 
 * Panels 
 */

.panel { margin-bottom: 20px; background-color: #fff; border-radius: 4px; }    

.panel-body { padding: 20px; }

.panel-heading, .panel header { padding: 10px 20px; border-bottom: 1px solid #f2f2f2;
   font-size: 16px; line-height: 19px; font-color: # }

