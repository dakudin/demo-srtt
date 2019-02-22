<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 01.07.2018
 * Time: 9:55
 */
/* @var $model common\models\TravelQuote */
?>

<!-- copy of input fields group -->
<div class="fieldGroupCopy" style="display: none;">
    <div class="panel-heading">
        <h3 class="panel-title panel_title_m">Room <span class="roomNumber">roomNumberValue</span>
        <a href="javascript:void(0)" class="roomRemove pull-right"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
        </h3>
    </div>

    <div class="panel-body">
        <label class="col-xs-6 col-sm-2 col-md-2 control-label" for="TravelQuote[room][][adult]">Adults</label>
        <div class="input-group col-xs-6 col-sm-3 col-md-2">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number"data-type="minus" data-field="TravelQuote[room][][adult]">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </span>
            <input type="text" id="TravelQuote[room][][adult]" name="TravelQuote[room][][adult]" class="form-control input-number" value="2" min="<?= $model::MIN_ADULTS_COUNT ?>" max="<?= $model::MAX_ADULTS_COUNT ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="TravelQuote[room][][adult]">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>

        <label class="col-xs-6 col-sm-2 col-md-2 control-label" for="TravelQuote[room][][child]">Children</label>
        <div class="input-group col-xs-6 col-sm-3 col-md-2">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="TravelQuote[room][][child]">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </span>
            <input type="text" id="TravelQuote[room][][child]" name="TravelQuote[room][][child]" class="form-control input-number" data-room="" data-field="childCount" value="0" min="<?= $model::MIN_CHILD_COUNT ?>" max="<?= $model::MAX_CHILD_COUNT ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="TravelQuote[room][][child]">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>

        <div class="form-group fieldChildAge" style="display: none;"></div>
    </div>
</div>

<!-- copy of input child age -->
<div class="form-group fieldChildAgeCopy" style="display: none;">
    <label class="col-xs-6 col-sm-2 col-md-2 control-label" for="TravelQuote[room][][childage]">&bull; Child's age</label>
    <div class="input-group col-xs-6 col-sm-3 col-md-2">
        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="TravelQuote[room][][childage]">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </span>
        <input type="text" id="TravelQuote[room][][childage]" name="TravelQuote[room][][childage]" class="form-control input-number" value="1" min="<?= $model::CHILDREN_MIN_AGE?>" max="<?= $model::CHILDREN_MAX_AGE?>">
        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="TravelQuote[room][][childage]">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </span>
    </div>
</div>

