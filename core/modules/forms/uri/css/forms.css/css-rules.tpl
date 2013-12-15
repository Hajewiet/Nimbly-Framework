/*
* forms.css
*/

label { display: block; cursor: text; margin: 0px 5px 0px 0px; vertical-align: bottom; }

.group label { margin-top: 0px; }

input[type=text] { margin-bottom: 6px; padding: 0px 2px; height: 20px; }

input.large[type=text] { width: 240px; }

input.small[type=text] { width: 80px; }

label input { margin-bottom: 0px; }

form .help { color: #888; vertical-align: top;}

textarea { width: 240px; padding: 0px 2px; min-height: 38px; vertical-align: bottom;
    margin-bottom: 10px;}

textarea.large { width: 480px; height: 138px; }

textarea.box { width: 99.6%; max-width: 99.6%; min-height: 60px;  }

select.box { padding: 5px; }

fieldset { border: 1px solid #ccc; padding: 0px 10px 10px 10px; 
    margin-top: 9px; }

legend { font-size: 12px; color: #777; }

fieldset fieldset, fieldset.section, .section fieldset { border: 0; padding: 0; }

fieldset fieldset legend, .section legend { display: block; height: 19px; 
    border-bottom: 1px solid #eee; margin-bottom: 10px; width: 100%; }

select { margin-bottom: 10px; }
    
/* Buttons */

input[type=submit], input[type=button], .button { height: 30px; line-height: 1px;
    padding: 0px 10px; text-decoration: none; color: #333; border-radius: 2px; 
    border: 1px solid transparent; box-shadow: none; cursor: pointer; font-weight: bold; 
    display: inline-block; background: #bbb; color: #fff; }
        
input[type=submit]:hover, input[type=button]:hover, .button:hover { background: #aaa; }  

.button.color { background: #7ab9d4; }

.button.color:hover { background: #6aa9c4; }
   
input[type=radio], input[type=checkbox] { height: 20px; }

.button.primary { height: 40px; line-height: 40px; padding: 0px 20px; }

.button.small { height: 24px; line-height: 20px; margin: 3px 0px; }

.button.secondary { height: 20px; line-height: 20px; background: none; border: none; 
    text-decoration: underline; color: #555; cursor: pointer; padding: 0; vertical-align: bottom; }
        
.button.secondary:active { background: none; color: skyblue; }

.button.secondary:hover { background: none; color: blue; }

.button.round { border-radius: 10px; }

.button.active, .button.active:hover, .button.disabled, .button[disabled],
.button.disabled, .button.disabled:hover { filter: alpha(opacity=100);
  -moz-opacity: 1; opacity: 1; background: #d1d1d1; border: 1px solid #b3b3b3;
  text-shadow: 0 1px 1px #fff; }

.button.active, .button.active:hover { color: #666; }

.button.disabled, .button[disabled], .button.disabled, .button.disabled:hover {
  color: #999; }

.button:focus .halflings, .button:hover .halflings { color: #555555; }

.button.single, .button.group { display: inline-block; margin-right: 2px; vertical-align: bottom; }

.button.single:after, .button.group:after { content: ".";  display: block; height: 0;
  clear: both; visibility: hidden; }
  
.button.single > .button, .button.single > input, .button.group > .button,
    .button.group > input { float: left; border-radius: 0; margin-left: -1px; }

.button.single > .button { border-radius: 4px; }

.button.group > .button:first-child { border-radius: 4px 0 0 4px; }

.button.group > .button:last-child { border-radius: 0 4px 4px 0; }

.button.group > .button.button.round:first-child, .button.group > .input-search:first-child {
  border-radius: 15px 0 0 15px; }

.button.group > .button.button.round:last-child, .button.group > .input-search:last-child {
  border-radius: 0 15px 15px 0; }

.button.append { position: relative; top: -1px; margin-left: -2px; border-radius: 0 4px 4px 0; }
    
/* Inline */

.inline label, label.inline { display: inline; vertical-align: middle; line-height: 30px; }

.inline input[type], input.inline[type] { margin-bottom: 0px; margin-right: 10px; 
    vertical-align: middle; }

.inline .group { display: inline; }

.inline input[type=checkbox], .inline input[type=radio] { margin-right: 0px;  }

.inline .button.small { vertical-align: middle; margin: 0; margin-top: -2px; }

 /* validaton messages */
 
 form .errors { color: red; }
 
/* Labels on the Left */

form .fleft { float: left; clear: left; display: block; width: 140px; text-align: right; 
    min-height: 10px; }
    
form .fright { float: left; margin-left: 4px; }

/* Dialog */

.dialog { width: 640px; height: 400px; position: absolute; top:0; bottom: 0;
	left: 0; right: 0; margin: auto; border: 5px solid #eee; padding: 10px 20px;
        background: white; color: #555; border-radius: 10px; box-shadow: 0px 0px 20px rgba(50, 50, 50, 0.8); }
        
.dialog h1 { margin: -10px -20px 20px -20px; background: #eee; text-align: center; 
    font-size: 27px; line-height: 40px; }    
    
.dialog h2 { font-size: 20px; line-height: 30px; margin-bottom: 10px; }
        
.dialog-page { background: rgba(0,0,0,0.2); }

/* Step indicator */

.steps { display: inline-block; box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.35);
	overflow: hidden; border-radius: 5px; counter-reset: step; margin: 0 }

.steps a, .steps li { text-decoration: none; outline: none; display: block; float: left;
    color: #444; line-height: 30px; padding: 0 10px 0 60px; position: relative;  }
        
.steps a:first-child, .steps li:first-child { padding-left: 46px; border-radius: 5px 0 0 5px; }

.steps a:first-child:before, .steps li:first-child:before { left: 14px; }

.steps a:last-child, .steps li:last-child { border-radius: 0 5px 5px 0; padding-right: 20px; }

.steps a.active, .steps a:hover, .steps li.active { background: skyblue; }

.steps a.active:after, .steps a:hover:after, .steps li.active:after { background: skyblue; }

.steps a:after, .steps li:after { content: ''; position: absolute; top: 0;  right: -15px; width: 30px; 
	height: 30px; -webkit-transform: scale(0.707) rotate(45deg); z-index: 1;
        background: white;
	box-shadow: 2px -2px 0 2px rgba(0, 0, 0, 0.4), 3px -3px 0 2px rgba(255, 255, 255, 0.1);
        border-radius: 0 5px 0 50px;  }
        
.steps a:last-child:after, .steps li:last-child:after { content: none; }

.steps a:before, .steps li:before { content: counter(step); counter-increment: step; border-radius: 100%;
        background: white; width: 20px; height: 20px; line-height: 20px; margin: 5px 0; 
        box-shadow: 0 0 0 1px #ccc; position: absolute; top: 0; left: 30px; 
        font-weight: bold; text-align: center; }




