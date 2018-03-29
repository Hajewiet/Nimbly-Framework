<section class="nb-container medium">
    <form autocomplete="false" data-edit-autoenable data-edit-uuid="1" class="nb-form">
        [repeat data.fields]
        <input
            type="submit"
            value="Save"
            class="nb-button"
            data-post="[data.resource]"
            data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] created"}'
            />
    </form>
</section>
