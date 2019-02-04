# Perch Campaign Monitor App v1.0.0

Root Campaign monitor is an app to view campaign monitor lists and campaigns. Using perch forms you can also subscribe new users to your lists. All that is required is a Campaign monitor Client ID and Client API Key

This functions very similar to the Perch Mailchimp app.

## Installation

Upload the `root_campaign_monitor` directory to `perch/addons/apps` and add `root_campaign_monitor` to your `config/apps.php` file.

Example:
``` php
<?php
    $apps_list = array(
        'perch_forms',
        'root_campaign_monitor'
    );
```
Once installed you can set your Client ID and Client Key in the settings area.

## Using the App

Like standard Perch apps, the Campaign Monitor App can be accessed using the Apps menu in the top of the CMS admin area. Inside the app you are able to view your campaign monitor lists and campaigns. From here you can get your list IDs which will be needed to subscribe new users.

---

### Settings
There aren't many settings involved. You'll need to set the Client ID and the Client API key to work. There is an additional setting for updating data.

The app will save the content retrieved from campaign monitor to provide better performance. You can choose the delay for how long the app should wait before updating data again. Below is a list of update categories

|Name|Value|
|---|---|
|campaigns|N/A|
|campaignSingle|Perch Campaign ID|
|lists|N/A|
|listSingle|Perch List ID|
|subscribersActive|Campaign Monitor List ID|
|subscribersUnconfirmed|Campaign Monitor List ID|
|subscribersUnsubscribed|Campaign Monitor List ID|
|subscribersBounced|Campaign Monitor List ID|
|subscribersDeleted|Campaign Monitor List ID

The time is set when the that specific item was last updated. Whenever an update takes place the item is marked in teh database. When the update timings are meet the update will run and the new content will be saved.

### Subscribing New Users
Root Campaign Monitor uses forms to add new subscribers to Campaign Monitor lists.

On an existing form add the root_campaign_forms to the app attribute on your forms tag.

```HTML
<perch:form id="sign_up" app="perch_forms root_campaign_monitor">
```

Note: Perch will execute the form handlers in the order you write them out. This shouldn't cause any issues unless you have a redirect on the `perch_form`. If a redirect is set the form will redirect the user before the `root_campaign_monitor` handler will not be called.

### Required Fields
To subscribe a user to a list you'll need to add the list_id to a hidden form element.

``` HTML
<perch:input id="list_id" type="hidden" value="abc121231" />
```

You can add multiple List IDs by adding the `campaign` attribute and setting the attribute id to list_id.

``` HTML
<perch:input id="list_id_2" type="hidden" value="abc121231" campaign="list_id" />
```

To submit a user through you'll need to pass their name and email address through. This is done using the campaign attribute.

``` HTML
<perch:input id="name" label="Name" campaign="name" type="text"/>
<perch:input id="email" label="Email" campaign="email" type="text"/>
```

### Consent

You'll need consent from the user to subscribe them. This can be implicitly granted or set with a checkbox.
``` HTML
<perch:input type="checkbox" id="consent" name="Consent" campaign="consent" label="Consent" value="Yes"/>
<perch:input id="consent" campaign="consent" type="hidden" value="Yes" />
```

### Optional Fields

The resubscribe option can be set in a similar fashion to consent.
``` HTML
<perch:input type="checkbox" id="resubscribe" name="resubscribe" campaign="resubscribe" label="Resubscribe" value="Yes"/>
<perch:input id="resubscribe" campaign="resubscribe" type="hidden" value="Yes" />
```

If the campaign attribute value doesn't match any of the default fields, they'll be added as a custom field for the list. If you list uses a company field you can use the following to subscribe the user with a company attribute

``` HTML
<perch:input id="company" label="Company" campaign="company" type="text"/>
```

---

### Example

``` HTML
<perch:form class="o-form" id="contact" app="perch_form root_campaign_monitor">

    <div class="o-field">
        <perch:label class="o-field__label c-label" for="name">Name</perch:label>
        <perch:input class="o-field__input c-input" id="name" label="Name" campaign="name" type="text"/>
    </div>

    <div class="o-field">
        <perch:label class="o-field__label c-label" for="email">Email</perch:label>
        <perch:input class="o-field__input c-input" id="email" label="Email" campaign="email" type="text"/>
    </div>

    <div class="o-field">
        <perch:label class="o-field__label c-label" for="company">Company</perch:label>
        <perch:input class="o-field__input c-input" id="company" label="Company" campaign="company" type="text"/>
    </div>

    <div class="o-field">
        <perch:label class="o-field__label c-label" for="name">Name</perch:label>
        <perch:input class="o-field__input c-input" id="name" campaign="name" type="textarea"/>
    </div>

    <div class="o-field">
        <div class="o-form__toggles">
            <perch:label class="c-toggle" for="keep_details">
                Keep my details on file for future contact
                <perch:input type="checkbox" class="c-toggle__control" id="keep_details" name="keep_details" campaign="resubscribe" label="Keep details on file" value="Yes"/>
            </perch:label>

            <perch:label class="c-toggle" for="receive_emails">
                I am happy to receive future contact by email
                <perch:input type="checkbox" class="c-toggle__control" id="receive_emails" name="receive_emails" campaign="consent" label="Receive future emails" value="Yes"/>
            </perch:label>
        </div>
    </div>

    <div class="o-form__controls">
        <perch:input id="list_id" value="abc12345" type="hidden"/>
        <perch:input type="submit" value="Sign Up" class="c-button"/>
    </div>

</perch:form>
```

## License

The MIT License (MIT)

Copyright (c) 2019 Root Studio

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.