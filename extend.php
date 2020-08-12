<?php

/*
 * This file is part of nosun/flarum-wechat-share.
 *
 * Copyright (c) 2020 nosun.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Nosun\WechatShare;

use Flarum\Extend;
use EasyWeChat\OfficialAccount;
use Flarum\Frontend\Document;

$config = app('flarum.config');
$app = new OfficialAccount\Application($config['wechat']);
$jsConfig = $app->jssdk->buildConfig(['updateAppMessageShareData', 'updateTimelineShareData']);

return [

    (new Extend\Frontend('forum'))
        ->content(function (Document $document) use ($jsConfig) {
            $document->head[] = '<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8" ></script>';
            $document->head[] = '<script> wx.config(' . $jsConfig . ')</script>';
            $document->head[] = "<script>

       var title = document.title;
       var url = window.location.href;
       var text = window.getSelection();

        wx.ready(function () {
            wx.updateAppMessageShareData({
                title: title,
                desc: text,
                link: url,
                imgUrl: 'https://www.childforge.com/assets/logo-wxwg9kxc.png',
                success: function () {
                }
            })
        });

        wx.ready(function () {
            wx.updateTimelineShareData({
                title: title,
                link: url,
                imgUrl: 'https://www.childforge.com/assets/logo-wxwg9kxc.png',
                success: function () {
                }
            })
        });

</script>";
        })
];
