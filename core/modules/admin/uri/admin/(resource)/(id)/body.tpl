<section class="nb-container medium">
    <h1>Edit [resource-name [data.resource]]</h1>
    <form autocomplete="false" data-edit-autoenable data-edit-uuid="[data.uuid]" class="nb-form">
        [repeat data.fields]
        <div class="nb-actions">
            <input
                type="submit"
                value="Save"
                class="nb-button"
                data-put="[data.resource]/[data.uuid]"
                data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] updated"}'
            />
        </div>
    </form>
</section>
