<section class="container medium">
    <form>
        <label>URL:
            <input type="text" maxlength="64" name="url" value="[get data.page.url]" required disabled />
        </label>
        <label>Template:
            <textarea name="template">[get data.page.template echo]</textarea>
        </label>
        <input
            type="submit"
            value="Save"
            class="button"
            data-put=".pages/[data.page.uuid]"
            data-done='{"redirect": "admin/pages", "msg": "Page `[data.page.url]` updated"}'
        />
  </form>
</section>
