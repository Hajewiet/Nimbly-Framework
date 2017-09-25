<section class="container medium">
    <form autocomplete="false" data-edit-autoenable>
            [repeat data.fields]
            <input
                type="submit"
                value="Save"
                class="button"
                data-put="[data.resource]/[data.uuid]"
                data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] updated"}'
            />
    </form>
</section>
