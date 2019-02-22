<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 01.07.2018
 * Time: 9:54
 */
/* @var $model common\models\TravelQuote */
?>
<div class="col-xs-12 col-sm-12 col-md-12"><p></p>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default fieldGroup">
        <div class="panel-heading">
            <h3 class="panel-title panel_title_m">Room <span class="roomNumber">1</span></h3>
        </div>

        <div class="panel-body">
            <label class="col-xs-6 col-sm-2 col-md-2 control-label" for="TravelQuote[room][1][adult]">Adults</label>
            <div class="input-group col-xs-6 col-sm-3 col-md-2">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="TravelQuote[room][1][adult]">
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </span>
                <input type="text" id="TravelQuote[room][1][adult]" name="TravelQuote[room][1][adult]" class="form-control input-number" value="2" min="<?= $model::MIN_ADULTS_COUNT ?>" max="<?= $model::MAX_ADULTS_COUNT ?>">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="TravelQuote[room][1][adult]">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </span>
            </div>

            <label class="col-xs-6 col-sm-2 col-md-2 control-label" for="TravelQuote[room][1][child]">Children</label>
            <div class="input-group col-xs-6 col-sm-3 col-md-2">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="TravelQuote[room][1][child]">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button>
                </span>
                <input type="text" id="TravelQuote[room][1][child]" name="TravelQuote[room][1][child]" class="form-control input-number" data-room="1" data-field="childCount" value="0" min="<?= $model::MIN_CHILD_COUNT ?>" max="<?= $model::MAX_CHILD_COUNT ?>">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="TravelQuote[room][1][child]">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </span>
            </div>

            <div class="form-group fieldChildAge" style="display: none;"></div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <div class="input-group">
                    <a href="javascript:void(0)" class="btn btn-success addMoreRoom"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add room</a>
            </div>
        </div>
    </div>
</div>