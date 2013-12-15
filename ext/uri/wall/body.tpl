<div class="row">
    <div class="col-20">
        <div class="pd-right">
            <div class="panel">
                <header class="panel-heading">Filters</header>
                <div class="panel-body">
                    <h6>Space</h6>
                    <ul>
                        <li><a href="#" data-filter='{"key": "wall-post", "space": 0}' data-trigger='{"key": "wall-post"}'>Any</a></li>
                        [js-embed tpl=space-filter url=[url-space-get] items=rows]
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-60">
        <div class="panel">
            <header class="panel-heading">Superwall</header>
            <div class="panel-body">
                <form name="wall-post" action="#" method="post" accept-charset="utf-8" data-post='{"url": "[url-node-post]", "key": "wall-post"}' >
                    [form-key wall-post]
                    <textarea name="title" class="box" placeholder="Type a message here..."></textarea>
                    <input type='hidden' name='uid' value='1' />


                    <div class="pull-left">
                        <a class="icon icon-refresh mg-right-small" title="Refresh" data-trigger='{"key": "wall-post"}'> </a>
                        <a class="icon icon-camera mg-right-small" title="Image" > </a>
                        <a class="icon icon-link mg-right-small" title="Link" > </a>
                        <a class="icon icon-file mg-right-small" title="File" > </a>
                    </div>
                    <div class="pull-right lh-large">
                        <div class="pull-left">
                            <select data-get='{"url": "[url-space-get]", "tpl": "space-dd", "items": "rows", "key": "space-dd"}' 
                                    name="space" class="box mg-right pull-right">
                            </select>  
                        </div>
                        <input type="submit" value="Deel" class="button color" /> 
                    </div>

                </form>
                <div class="clearfix mg-top-large" data-get='{"url": "[url-node-get]", "tpl": "wall-post", "items": "rows", "key": "wall-post", "order" : "desc"}'>
                </div>
            </div>
        </div>
    </div>
    <div class="col-20">
        <div class="pd-left">
            <div class="panel">
                <header class="panel-heading">Right column</header>                
                <div class="panel-body">
                    [ipsum words=10]
                </div>
            </div>
        </div>
    </div>


</div>

[js-embed tpl="wall-post"]
[js-embed tpl="space-dd"]