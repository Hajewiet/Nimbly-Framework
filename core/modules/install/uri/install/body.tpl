<div class="row">
    <div class="medium-6 medium-centered columns">

        <h1>[text Installation]</h1>

        <div class="progress" role="progressbar" tabindex="0" aria-valuenow="[step]" aria-valuemin="1" aria-valuetext="[text step[step]_short]" aria-valuemax="3">
            <span class="progress-meter" style="width: [if step=1 echo=33.33%][if step=2 echo=66.66%][if step=3 echo=100%]">
                <p class="progress-meter-text"></p>
            </span>
        </div>

        <p><strong>[text Step] [step]: [text step[step]_long]</strong></p>

        <form name="step[step]" action="[url].php" method="post" accept-charset="utf-8" data-abide novalidate>
            [form-error]
            [form-key step[step]]
            [step[step]]
        </form>
    </div>
</div>