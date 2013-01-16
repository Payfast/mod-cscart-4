<div class="form-field">
	<label for="merchant_id">{$lang.merchant_id}:</label>
	<input type="text" name="payment_data[processor_params][merchant_id]" id="merchant_id" value="{$processor_params.merchant_id}" class="input-text" />
</div>
<div class="form-field">
	<label for="merchant_key">{$lang.merchant_key}:</label>
	<input type="text" name="payment_data[processor_params][merchant_key]" id="merchant_key" value="{$processor_params.merchant_key}" class="input-text" />
</div>

<div class="form-field">
	<label for="mode">{$lang.text_payfast_sandbox_live}:</label>
	<select name="payment_data[processor_params][mode]" id="mode">
		<option value="sandbox" {if $processor_params.mode == "sandbox"}selected="selected"{/if}>{$lang.sandbox}</option>
		<option value="live" {if $processor_params.mode == "live"}selected="selected"{/if}>{$lang.live}</option>
	</select>
</div>
<div class="form-field">
    <label for="debug">{$lang.text_debug}:</label>
    <select name="payment_data[processor_params][debug]" id="debug">
        <option value="true" {if $processor_params.debug}selected="selected"{/if}>{$lang.true}</option>
        <option value="false" {if !$processor_params.debug}selected="selected"{/if}>{$lang.false}</option>
    </select>
</div>

{include file="common_templates/subheader.tpl" title=$lang.text_payfast_status_map}

{assign var="statuses" value=$smarty.const.STATUSES_ORDER|fn_get_statuses:true}

<div class="form-field">
	<label for="payfast_completed">{$lang.completed}:</label>
	<select name="payment_data[processor_params][statuses][completed]" id="payfast_completed">
		{foreach from=$statuses item="s" key="k"}
		<option value="{$k}" {if (isset($processor_params.statuses.completed) && $processor_params.statuses.completed == $k) || (!isset($processor_params.statuses.completed) && $k == 'P')}selected="selected"{/if}>{$s}</option>
		{/foreach}
	</select>
</div>

<div class="form-field">
	<label for="payfast_failed">{$lang.failed}:</label>
	<select name="payment_data[processor_params][statuses][failed]" id="payfast_failed">
		{foreach from=$statuses item="s" key="k"}
		<option value="{$k}" {if (isset($processor_params.statuses.failed) && $processor_params.statuses.failed == $k) || (!isset($processor_params.statuses.failed) && $k == 'F')}selected="selected"{/if}>{$s}</option>
		{/foreach}
	</select>
</div>

