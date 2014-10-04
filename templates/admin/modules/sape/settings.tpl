{% import 'macro/settings.tpl' as settingstpl %}
{% import 'macro/notify.tpl' as notifytpl %}
<h1>{{ extension.title }}<small>{{ language.admin_modules_sape_settings_title }}</small></h1>
<hr />
{% if notify.save_success %}
    {{ notifytpl.success(language.admin_extension_config_update_success) }}
{% endif %}
<form method="post" action="" class="form-horizontal">
    <fieldset>
        {{ settingstpl.textgroup('sape_user', config.sape_user, 'Sape user', language.admin_modules_sape_settings_uesr_desc ) }}
    </fieldset>
    <input type="submit" name="submit" value="{{ language.admin_modules_sape_settings_save }}" class="btn btn-success"/>
</form>