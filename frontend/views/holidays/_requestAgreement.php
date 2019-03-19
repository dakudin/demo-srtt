<div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-8 quote-form__confirmation">
    <label>
        <input type="checkbox" id="acceptConfirm1" name="accept-confirm1" />
        <span style="padding-left: 5px"><?php echo \common\components\QuoteHelper::QUOTE_CONFIRMATION_TEXT ?></span>
    </label>
    <label>
        <input type="checkbox" id="acceptConfirm2" name="accept-confirm2" />
        <span style="padding-left: 5px"><?php echo \common\components\QuoteHelper::getQuoteMarketingConsent() ?></span>
    </label>
</div>
