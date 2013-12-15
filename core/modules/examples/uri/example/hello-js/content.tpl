<h2>Hello World</h2>

<form name="hello" action="[url]" method="post" accept-charset="utf-8">
    [form-key hello]
    <label>Name:</label>
    <input type="text" placeholder="Enter a name here" name="name" id="name" value="[sticky name]" [js-push yourname] />
</form>

<h3>Hello [js-widget tpl=echo data=yourname default=""]!</h3>