<section class="nb-container medium">
    <h1>Route</h1>
    <form class="nb-form">
        <label>Route:
            <input type="text" maxlength="64" name="route" value="[get data.routes.route]" required />
        </label>
        <label>Order:
            <input type="text" maxlength="64" name="order" value="[get data.routes.order]" required />
        </label>
        <input
            type="submit"
            value="Save"
            class="nb-button"
            data-put=".routes/[data.routes.uuid]"
            data-done='{"redirect": "admin/routes", "msg": "Route `[data.routes.route]` updated"}'
        />
  </form>
</section>
