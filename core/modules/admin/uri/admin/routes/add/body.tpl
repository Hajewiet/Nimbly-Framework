<section class="nb-container medium">
    <h1>Add route</h1>
    <form class="nb-form">
            <label>URL:
                <input type="text" maxlength="64" name="route"
                       placeholder="route, example: admin/routes/(id)" value="[sticky route]" required />
            </label>
            <label>Order:
                <input type="text" maxlength="64" name="order"
                       placeholder="order, example: 500" value="[sticky order]" required />
            </label>
            <input type="hidden" name="pk" value="route" />
            <input
                type="submit"
                value="Save"
                class="nb-button"
                data-post=".routes"
                data-done='{"redirect": "admin/routes", "msg": "Route created"}'
            />
      </form>
</section>
