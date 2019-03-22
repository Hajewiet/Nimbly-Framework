
<h1>Edit page</h1>
<form class="nb-form">
    <label>URL:
        <input type="text" maxlength="64" name="url" value="[get data.page.url]" required disabled />
    </label>
    <label>Template:
        <textarea name="template">[get data.page.template echo]</textarea>
    </label>
    <div class="nb-actions">
        <input
            type="submit"
            value="Save"
            class="nb-button"
            data-put=".pages/[data.page.uuid]"
            data-done='{"redirect": "admin/pages", "msg": "Page `[data.page.url]` updated"}'
        />
    </div>
</form>
