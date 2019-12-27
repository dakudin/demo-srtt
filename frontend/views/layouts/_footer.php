<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 hidden-xs">
                <div class="pull-left">&copy; Sortit <?= date('Y') ?></div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <ul class="list-unstyled">
                    <li class="panel_title_m">More from Sortit</li>
                    <li><a href="<?= \yii\helpers\Url::to(['/site/about']) ?>" title="About us">About us</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>" title="Contact us">Contact us</a></li>
                    <li><a href="<?= $this->params['footer_links']['termsofuse_url'] ?>" title="Terms of Use" target="termsOfUse">Terms of Use</a></li>
                    <li><a href="<?= $this->params['footer_links']['privacy_police_url'] ?>" title="Privacy Policy" target="privacyAndCookies">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-3 col-xs-8">
                <ul class="list-unstyled">
                    <li class="panel_title_m">Popular quotes</li>
                    <?php $popularCategories = \frontend\helpers\FHelper::getMostPopularCategoryLinks();
                        foreach($popularCategories as $popularCategory):
                    ?>
                        <li>
                            <a href="<?= $popularCategory['url'] ?>" title="<?= $popularCategory['label'] . ' holidays' ?>"><?= $popularCategory['label'] . ' holidays' ?></a>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-4 col-sm-3 col-xs-12 social-icons">
                <div class="pull-left hidden-sm hidden-md hidden-lg">&copy; Sortit <?= date('Y') ?></div>
                <ul class="list-inline pull-right">
                    <li>
                        <a href="https://www.facebook.com/wesortitforyou/" target="_blank" title="Like us on Facebook"><img src="/images/facebook.png" alt="Visit our Facebook page"></a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/sortit.com/about/" target="_blank" title="Visit our LinkedIn page"><img src="/images/linkedin.png" alt="Visit our LinkedIn page"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
