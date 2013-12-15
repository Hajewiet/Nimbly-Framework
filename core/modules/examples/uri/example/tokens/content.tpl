<h2>Tokens</h2>
<br />

<p>
    Tokens can be implemented in 3 different ways. 
</p>

<h6>Example:</h6>
[set token2=two]
<p class="highlight">[token1] [token2] [token3]</p>

<h6>Code:</h6>
<ul class="tabs">
    <li class="active"><a href="#code">Code</a></li>
    <li><a href="#token1">token1</a></li>
    <li><a href="#token2">token2</a></li>
    <li><a href="#token3">token3</a></li>
</ul>
<br />

<div class="tab-content active" id="code">
    <pre class="highlight">\[token1] \[token2] \[token3]</pre>
</div>

<div class="tab-content" id="token1">
    <pre class="highlight">file token1.tpl contains:

one
    </pre>
</div>

<div class="tab-content" id="token2">
    <pre class="highlight">\[set token2=two]</pre>
</div>

<div class="tab-content" id="token3">
    <pre class="highlight">file token3.php contains:

function token3_token() {
    return "three";
}
    </pre>
</div>


<h6>What to learn from this example:</h6>
<ol>
    <li>[app-name] has a build-in template engine.</li>
    <li>Template files have the file extension ".tpl".</li>
    <li>Data binding in templates is done via tokens.</li>
    <li>Token syntax is with square brackets, e.g. \[greeting].</li>
    <li>A token can be implemented with a template file, using the same name as the token, e.g. greeting.tpl.</li>
    <li>A token implementation can be as simple as plain text, like "[greeting]".</li>
</ol>
<br />
<p>
    <a class="secondary button space right" href="[base-url]example/hello">Previous example: Hello World</a>
    <a class="button" href="[base-url]example/bla">Next example: Bla</a>
</p>
