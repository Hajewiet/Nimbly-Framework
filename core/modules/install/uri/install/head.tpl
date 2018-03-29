<style>
    [set primary-color="#58c8f4"]
    [run tpl="css/app.css/nimbly.css.tpl"]
    .progress-bar {
        position: relative;
        height: 1rem;
        background-color: #eee;
        margin-bottom: 1rem;
    }
    .progress-meter {
        position: absolute;
        height: 1rem;
        background-color: [primary-color];
    }
    <div class="progress-bar">
            <div class="progress-meter" style="width: [if step=1 echo=33.33%][if step=2 echo=66.66%][if step=3 echo=100%]">
            </div>
        </div>
</style>
