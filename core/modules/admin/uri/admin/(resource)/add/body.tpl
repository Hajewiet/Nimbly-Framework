<section class="nb-container medium">
    <h1>Add [resource-name [data.resource]]</h1>
    <form autocomplete="false" data-edit-autoenable data-edit-uuid="1" class="nb-form">
        [repeat data.fields]
        <div class="nb-actions">
            <input
            type="submit"
            value="Save"
            class="nb-button"
            data-post="[data.resource]"
            data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] created"}'
            />
        </div>
    </form>
</section>
