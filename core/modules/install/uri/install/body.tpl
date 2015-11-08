<div class="dialog">
    <h1>[text Installation]</h1>
    
    <ul class="steps">
        <li class="[if step=1 echo=active]">[text step1_short]</li>
        <li class="[if step=2 echo=active]">[text step2_short]</li>
        <li class="[if step=3 echo=active]">[text step3_short]</li>
        <li class="[if step=4 echo=active]">[text step4_short]</li>
    </ul>
    
     <h2>[text Step] [step]: [text step[step]_long]</h2>
    
    <form name="step[step]" action="[url].php" method="post" accept-charset="utf-8">
        [form-key step[step]]
        [step[step]]
    </form>
</div>