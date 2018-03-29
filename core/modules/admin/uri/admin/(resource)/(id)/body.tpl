<section class="nb-container medium">
    <form autocomplete="false" data-edit-autoenable data-edit-uuid="[data.uuid]" class="nb-form">
        [repeat data.fields]
        <input
            type="submit"
            value="Save"
            class="nb-button"
            data-put="[data.resource]/[data.uuid]"
            data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] updated"}'
        />
    </form>
</section>
