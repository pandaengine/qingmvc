{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
<b>{$Name|upper}</b>
{include file="footer.tpl"}
