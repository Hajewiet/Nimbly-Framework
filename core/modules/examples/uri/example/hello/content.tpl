<h2>Hello World</h2>
<br />

<p>
    This example demonstrates the (almost) minimum of what's needed to display 
    the text "[greeting]" on a page. 
</p>

<h6>Example:</h6>
<p class="highlight">[greeting]</p>

<h6>Code:</h6>
<ul class="tabs">
    <li class="active"><a href="#content">content.tpl</a></li>
    <li><a href="#greeting">greeting.tpl</a></li>
</ul>
<br />
<div class="tab-content active" id="content">[code-content]</div>
<div class="tab-content" id="greeting"><pre class="highlight">[greeting]</pre></div>

<h6>What to learn from this example:</h6>
<ol>
    <li>[app-name] has a build-in template engine.</li>
    <li>Template files have the file extension ".tpl".</li>
    <li>Data binding in templates is done via tokens.</li>
    <li>Token syntax is with square brackets, e.g. \[greeting].</li>
    <li>A token can be implemented with a template file, using the same name as the token, e.g. greeting.tpl.</li>
    <li>A token implementation can be as simple as plain text, like "[greeting]".</li>
</ol>

<blockquote>Note: The <code>\[greeting]</code> token is not really needed, you could type 
    the greeting text directly in the content template:
    <pre class="highlight">&lt;p class="highlight">[greeting]&lt;/p> </pre>
    It was just added to demonstrate an easy way of creating and using tokens.</li>
</blockquote>
<br />

<p><a class="button" href="[base-url]example/tokens">Next example: Tokens</a></p>
