<div class="nb-container">

    <h1>[text Installation]</h1>

    <div class="progress-bar">
        <div class="progress-meter" style="width: [if step=1 echo=33.33%][if step=2 echo=66.66%][if step=3 echo=100%]">
        </div>
    </div>

    <p><strong>[text Step] [step]: [text step[step]_long]</strong></p>

    <form name="step[step]" action="[url].php" method="post" accept-charset="utf-8" class="nb-form">
        [form-error]
        [form-key step[step]]
        [step[step]]
    </form>
</div>
