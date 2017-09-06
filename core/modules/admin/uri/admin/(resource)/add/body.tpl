<section class="container medium">
    <form autocomplete="false">
            [repeat data.fields]
            <input
                type="submit"
                value="Save"
                class="button"
                data-post="[data.resource]"
                data-done='{"redirect": "admin/[data.resource]", "msg": "[resource-name [data.resource]] created"}'
            />
    </form>
</section>
