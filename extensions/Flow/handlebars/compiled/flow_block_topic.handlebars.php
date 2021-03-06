<?php return function ($in, $debugopt = 1) {
    $cx = Array(
        'flags' => Array(
            'jstrue' => false,
            'jsobj' => false,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'mustlok' => false,
            'debug' => $debugopt,
        ),
        'helpers' => Array(            'l10n' => 'Flow\TemplateHelper::l10n',
            'uuidTimestamp' => 'Flow\TemplateHelper::uuidTimestamp',
            'timestamp' => 'Flow\TemplateHelper::timestampHelper',
            'html' => 'Flow\TemplateHelper::htmlHelper',
            'post' => 'Flow\TemplateHelper::post',
            'l10nParse' => 'Flow\TemplateHelper::l10nParse',
            'linkWithReturnTo' => 'Flow\TemplateHelper::linkWithReturnTo',
            'escapeContent' => 'Flow\TemplateHelper::escapeContent',
            'plaintextSnippet' => 'Flow\TemplateHelper::plaintextSnippet',
),
        'blockhelpers' => Array(),
        'hbhelpers' => Array(            'eachPost' => 'Flow\TemplateHelper::eachPost',
            'ifAnonymous' => 'Flow\TemplateHelper::ifAnonymous',
            'ifCond' => 'Flow\TemplateHelper::ifCond',
            'tooltip' => 'Flow\TemplateHelper::tooltip',
            'progressiveEnhancement' => 'Flow\TemplateHelper::progressiveEnhancement',
),
        'scopes' => Array($in),
        'sp_vars' => Array(),

    );
    return '<div class="flow-board flow-disable-collapse">
	<div class="flow-topics">
		'.'
		'.LCRun3::sec($cx, ((is_array($in) && isset($in['roots'])) ? $in['roots'] : null), $in, true, function($cx, $in) {return '
	'.'
	'.LCRun3::hbch($cx, 'eachPost', Array(Array($cx['scopes'][0],$in),Array()), $in, function($cx, $in) {return '
		<div class="flow-topic flow-element-collapsible
            '.((!LCRun3::ifvar($cx, ((is_array($in) && isset($in['isPreview'])) ? $in['isPreview'] : null))) ? 'flow-load-interactive' : '').'
            '.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null))) ? 'flow-topic-moderatestate-'.htmlentities(((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null), ENT_QUOTES, 'UTF-8').'' : '').'
            '.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['isModerated'])) ? $in['isModerated'] : null))) ? 'flow-topic-moderated
              '.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null),'!==','lock'),Array()), $in, function($cx, $in) {return 'flow-element-collapsed';}).'
            ' : '').'"
     id="flow-topic-'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
     data-flow-id="'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
     data-flow-load-handler="collapserState"
     data-flow-collapser-set="topics"
>
	<div class="flow-topic-titlebar flow-click-interactive" data-flow-interactive-handler="collapserCollapsibleToggle" tabindex="0">
	<h2 class="flow-topic-title" data-title="'.LCRun3::ch($cx, 'plaintextSnippet', Array(Array(((is_array($in['content']) && isset($in['content']['format'])) ? $in['content']['format'] : null),((is_array($in['content']) && isset($in['content']['content'])) ? $in['content']['content'] : null)),Array()), 'encq').'">'.LCRun3::ch($cx, 'escapeContent', Array(Array(((is_array($in['content']) && isset($in['content']['format'])) ? $in['content']['format'] : null),((is_array($in['content']) && isset($in['content']['content'])) ? $in['content']['content'] : null)),Array()), 'encq').'</h2>
'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['isModerated'])) ? $in['isModerated'] : null))) ? '
	<div class="flow-moderated-topic-title flow-ui-text-truncated"><span
		class="wikiglyph '.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null),'===','lock'),Array()), $in, function($cx, $in) {return 'wikiglyph-lock';}).''.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null),'===','hide'),Array()), $in, function($cx, $in) {return 'wikiglyph-flag';}).''.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null),'===','delete'),Array()), $in, function($cx, $in) {return 'wikiglyph-trash';}).'"></span>
		'.LCRun3::ch($cx, 'l10n', Array(Array('post_moderation_state',((is_array($in) && isset($in['moderateState'])) ? $in['moderateState'] : null),((is_array($in) && isset($in['replyToId'])) ? $in['replyToId'] : null),((is_array($in['moderator']) && isset($in['moderator']['name'])) ? $in['moderator']['name'] : null)),Array()), 'encq').'</div>
' : '').'
<div class="flow-topic-meta">
	'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['reply'])) ? $in['actions']['reply'] : null))) ? '
		<a href="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['url'])) ? $in['actions']['reply']['url'] : null), ENT_QUOTES, 'UTF-8').'"
		   title="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['title'])) ? $in['actions']['reply']['title'] : null), ENT_QUOTES, 'UTF-8').'"
		   class="mw-ui-anchor mw-ui-progressive mw-ui-quiet"
		   data-flow-interactive-handler="activateForm">'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['title'])) ? $in['actions']['reply']['title'] : null), ENT_QUOTES, 'UTF-8').'</a>
		&bull;
	' : '').'

	'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-comments',((is_array($in) && isset($in['reply_count'])) ? $in['reply_count'] : null)),Array()), 'encq').' &bull;

	'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['last_updated'])) ? $in['last_updated'] : null))) ? '
		'.LCRun3::ch($cx, 'timestamp', Array(Array(((is_array($in) && isset($in['last_updated'])) ? $in['last_updated'] : null),'flow-active-ago',false,((is_array($in) && isset($in['last_updated_readable'])) ? $in['last_updated_readable'] : null)),Array()), 'encq').'
	' : '
		'.LCRun3::ch($cx, 'uuidTimestamp', Array(Array(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null),'flow-started-ago',false),Array()), 'encq').'
	').'
</div>
<span class="flow-reply-count"><span class="wikiglyph wikiglyph-speech-bubble"></span><span class="flow-reply-count-number">'.htmlentities(((is_array($in) && isset($in['reply_count'])) ? $in['reply_count'] : null), ENT_QUOTES, 'UTF-8').'</span></span>

<div class="flow-topic-summary-container">
	<div class="flow-error-container">
'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null))) ? '
	<div class="flow-errors errorbox">
		<ul>
			'.LCRun3::sec($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null), $in, true, function($cx, $in) {return '
				<li>'.LCRun3::ch($cx, 'html', Array(Array(((is_array($in) && isset($in['message'])) ? $in['message'] : null)),Array()), 'encq').'</li>
			';}).'
		</ul>
	</div>
' : '').'
</div>

	'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['summary'])) ? $in['summary'] : null))) ? '
		<div class="flow-topic-summary">
			'.LCRun3::ch($cx, 'escapeContent', Array(Array(((is_array($in['summary']) && isset($in['summary']['format'])) ? $in['summary']['format'] : null),((is_array($in['summary']) && isset($in['summary']['content'])) ? $in['summary']['content'] : null)),Array()), 'encq').'
		</div>
	' : '').'
</div>



	'.((!LCRun3::ifvar($cx, ((is_array($in) && isset($in['isPreview'])) ? $in['isPreview'] : null))) ? '
		'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['watchable'])) ? $in['watchable'] : null))) ? '
			<div class="flow-topic-watchlist flow-watch-link">
	<div class="flow-error-container">
'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null))) ? '
	<div class="flow-errors errorbox">
		<ul>
			'.LCRun3::sec($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null), $in, true, function($cx, $in) {return '
				<li>'.LCRun3::ch($cx, 'html', Array(Array(((is_array($in) && isset($in['message'])) ? $in['message'] : null)),Array()), 'encq').'</li>
			';}).'
		</ul>
	</div>
' : '').'
</div>


	<a href="'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['isWatched'])) ? $in['isWatched'] : null))) ? ''.htmlentities(((is_array($in['links']['unwatch-topic']) && isset($in['links']['unwatch-topic']['url'])) ? $in['links']['unwatch-topic']['url'] : null), ENT_QUOTES, 'UTF-8').'' : ''.htmlentities(((is_array($in['links']['watch-topic']) && isset($in['links']['watch-topic']['url'])) ? $in['links']['watch-topic']['url'] : null), ENT_QUOTES, 'UTF-8').'').'"
	   class="mw-ui-anchor mw-ui-constructive '.((!LCRun3::ifvar($cx, ((is_array($in) && isset($in['isWatched'])) ? $in['isWatched'] : null))) ? 'mw-ui-quiet' : '').'
	   '.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['isWatched'])) ? $in['isWatched'] : null))) ? 'flow-watch-link-unwatch' : 'flow-watch-link-watch').'"
	   data-flow-api-handler="watchItem"
	   data-flow-api-handler="watchTopic"
	   data-flow-api-target="< .flow-topic-watchlist"
	   data-flow-api-method="POST">'.htmlentities(((is_array($in) && isset($in['null'])) ? $in['null'] : null), ENT_QUOTES, 'UTF-8').'<span class="wikiglyph wikiglyph-star"></span>'.htmlentities(((is_array($in) && isset($in['null'])) ? $in['null'] : null), ENT_QUOTES, 'UTF-8').''.htmlentities(((is_array($in) && isset($in['null'])) ? $in['null'] : null), ENT_QUOTES, 'UTF-8').'<span class="wikiglyph wikiglyph-unstar"></span>'.htmlentities(((is_array($in) && isset($in['null'])) ? $in['null'] : null), ENT_QUOTES, 'UTF-8').'</a>
</div>

		' : '').'
		<div class="flow-menu">
			<div class="flow-menu-js-drop"><a href="javascript:void(0);"><span class="wikiglyph wikiglyph-ellipsis"></span></a></div>
			<ul class="mw-ui-button-container flow-list">
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['edit'])) ? $in['actions']['edit'] : null))) ? '
					<li>
						<a class="mw-ui-button mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['edit']) && isset($in['actions']['edit']['url'])) ? $in['actions']['edit']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['edit']) && isset($in['actions']['edit']['title'])) ? $in['actions']['edit']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="editTopicTitle"
								>
							<span class="wikiglyph wikiglyph-pencil"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-edit-title'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['links']) && isset($in['links']['topic-history'])) ? $in['links']['topic-history'] : null))) ? '
					<li>
						<a class="mw-ui-button mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['links']['topic-history']) && isset($in['links']['topic-history']['url'])) ? $in['links']['topic-history']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['links']['topic-history']) && isset($in['links']['topic-history']['title'])) ? $in['links']['topic-history']['title'] : null), ENT_QUOTES, 'UTF-8').'">
							<span class="wikiglyph wikiglyph-clock"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-history'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['links']) && isset($in['links']['topic'])) ? $in['links']['topic'] : null))) ? '
					<li>
						<a class="mw-ui-button mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['links']['topic']) && isset($in['links']['topic']['url'])) ? $in['links']['topic']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['links']['topic']) && isset($in['links']['topic']['title'])) ? $in['links']['topic']['title'] : null), ENT_QUOTES, 'UTF-8').'">
							<span class="wikiglyph wikiglyph-link"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-view'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['summarize'])) ? $in['actions']['summarize'] : null))) ? '
					<li>
						<a class="mw-ui-button mw-ui-progressive mw-ui-quiet"
						   data-flow-interactive-handler="apiRequest"
						   data-flow-api-handler="activateSummarizeTopic"
						   data-flow-api-target="< .flow-topic-titlebar .flow-topic-summary-container"
						   href="'.htmlentities(((is_array($in['actions']['summarize']) && isset($in['actions']['summarize']['url'])) ? $in['actions']['summarize']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['summarize']) && isset($in['actions']['summarize']['title'])) ? $in['actions']['summarize']['title'] : null), ENT_QUOTES, 'UTF-8').'">
							<span class="wikiglyph wikiglyph-stripe-toc"></span>
							'.((LCRun3::ifvar($cx, ((is_array($in) && isset($in['summary'])) ? $in['summary'] : null))) ? '
								'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-resummarize-topic'),Array()), 'encq').'
							' : '
								'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-summarize-topic'),Array()), 'encq').'
							').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['hide'])) ? $in['actions']['hide'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['hide']) && isset($in['actions']['hide']['url'])) ? $in['actions']['hide']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['hide']) && isset($in['actions']['hide']['title'])) ? $in['actions']['hide']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="hide">
							<span class="wikiglyph wikiglyph-flag"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-hide-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['unhide'])) ? $in['actions']['unhide'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['unhide']) && isset($in['actions']['unhide']['url'])) ? $in['actions']['unhide']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['unhide']) && isset($in['actions']['unhide']['title'])) ? $in['actions']['unhide']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="unhide">
							<span class="wikiglyph wikiglyph-flag"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-unhide-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['delete'])) ? $in['actions']['delete'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['delete']) && isset($in['actions']['delete']['url'])) ? $in['actions']['delete']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['delete']) && isset($in['actions']['delete']['title'])) ? $in['actions']['delete']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="delete">
							<span class="wikiglyph wikiglyph-trash"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-delete-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['undelete'])) ? $in['actions']['undelete'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['undelete']) && isset($in['actions']['undelete']['url'])) ? $in['actions']['undelete']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['undelete']) && isset($in['actions']['undelete']['title'])) ? $in['actions']['undelete']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="undelete">
							<span class="wikiglyph wikiglyph-trash"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-undelete-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['suppress'])) ? $in['actions']['suppress'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['suppress']) && isset($in['actions']['suppress']['url'])) ? $in['actions']['suppress']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['suppress']) && isset($in['actions']['suppress']['title'])) ? $in['actions']['suppress']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="suppress">
							<span class="wikiglyph wikiglyph-block"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-suppress-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['unsuppress'])) ? $in['actions']['unsuppress'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   href="'.htmlentities(((is_array($in['actions']['unsuppress']) && isset($in['actions']['unsuppress']['url'])) ? $in['actions']['unsuppress']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['unsuppress']) && isset($in['actions']['unsuppress']['title'])) ? $in['actions']['unsuppress']['title'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-interactive-handler="moderationDialog"
						   data-template="flow_moderate_topic"
						   data-role="unsuppress">
							<span class="wikiglyph wikiglyph-block"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-unsuppress-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['lock'])) ? $in['actions']['lock'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   data-flow-interactive-handler="apiRequest"
						   data-flow-api-handler="activateLockTopic"
						   data-flow-api-target="< .flow-topic-titlebar .flow-topic-summary-container"
						   data-flow-id="'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
						   href="'.htmlentities(((is_array($in['actions']['lock']) && isset($in['actions']['lock']['url'])) ? $in['actions']['lock']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['lock']) && isset($in['actions']['lock']['title'])) ? $in['actions']['lock']['title'] : null), ENT_QUOTES, 'UTF-8').'">
							<span class="wikiglyph wikiglyph-lock"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-lock-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['unlock'])) ? $in['actions']['unlock'] : null))) ? '
					<li class="flow-menu-moderation-action">
						<a class="mw-ui-button mw-ui-destructive mw-ui-quiet"
						   data-flow-interactive-handler="apiRequest"
						   data-flow-api-handler="activateLockTopic"
						   data-flow-id="'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
						   data-flow-api-target="< .flow-topic-titlebar .flow-topic-summary-container"
						   href="'.htmlentities(((is_array($in['actions']['unlock']) && isset($in['actions']['unlock']['url'])) ? $in['actions']['unlock']['url'] : null), ENT_QUOTES, 'UTF-8').'"
						   title="'.htmlentities(((is_array($in['actions']['unlock']) && isset($in['actions']['unlock']['title'])) ? $in['actions']['unlock']['title'] : null), ENT_QUOTES, 'UTF-8').'">
							<span class="wikiglyph wikiglyph-unlock"></span>
							'.LCRun3::ch($cx, 'l10n', Array(Array('flow-topic-action-unlock-topic'),Array()), 'encq').'
						</a>
					</li>
				' : '').'
			</ul>
		</div>
	' : '').'
</div>


	'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['posts'])) ? $cx['scopes'][0]['posts'] : null))) ? '
		'.LCRun3::sec($cx, ((is_array($in) && isset($in['replies'])) ? $in['replies'] : null), $in, true, function($cx, $in) {return '
			'.LCRun3::hbch($cx, 'eachPost', Array(Array($cx['scopes'][0],$in),Array()), $in, function($cx, $in) {return '
				<!-- eachPost topic -->
				'.LCRun3::ch($cx, 'post', Array(Array($cx['scopes'][0],$in),Array()), 'encq').'
			';}).'
		';}).'
	' : '').'

	'.((!LCRun3::ifvar($cx, ((is_array($in) && isset($in['isPreview'])) ? $in['isPreview'] : null))) ? '
		'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['reply'])) ? $in['actions']['reply'] : null))) ? '
			'.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($cx['scopes'][0]['submitted']) && isset($cx['scopes'][0]['submitted']['postId'])) ? $cx['scopes'][0]['submitted']['postId'] : null),'===',((is_array($in) && isset($in['postId'])) ? $in['postId'] : null)),Array()), $in, function($cx, $in) {return '
				'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['reply'])) ? $in['actions']['reply'] : null))) ? '
	<form class="flow-post flow-reply-form"
	      method="POST"
	      action="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['url'])) ? $in['actions']['reply']['url'] : null), ENT_QUOTES, 'UTF-8').'"
	      id="flow-reply-'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
	      data-flow-initial-state="collapsed"
	>
		<input type="hidden" name="wpEditToken" value="'.htmlentities(((is_array($cx['scopes'][0]['rootBlock']) && isset($cx['scopes'][0]['rootBlock']['editToken'])) ? $cx['scopes'][0]['rootBlock']['editToken'] : null), ENT_QUOTES, 'UTF-8').'" />
		<input type="hidden" name="topic_replyTo" value="'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'" />
		<div class="flow-error-container">
'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null))) ? '
	<div class="flow-errors errorbox">
		<ul>
			'.LCRun3::sec($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null), $in, true, function($cx, $in) {return '
				<li>'.LCRun3::ch($cx, 'html', Array(Array(((is_array($in) && isset($in['message'])) ? $in['message'] : null)),Array()), 'encq').'</li>
			';}).'
		</ul>
	</div>
' : '').'
</div>


		'.LCRun3::hbch($cx, 'ifAnonymous', Array(Array(),Array()), $in, function($cx, $in) {return '
			<div class="flow-anon-warning">
	<div class="flow-anon-warning-mobile">
		'.'
		'.LCRun3::hbch($cx, 'tooltip', Array(Array(),Array('positionClass'=>'down','contextClass'=>'progressive','extraClass'=>'flow-form-collapsible','isBlock'=>true)), $in, function($cx, $in) {return '
			'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-anon-warning',LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin'),Array()), 'raw'),LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin/signup'),Array()), 'raw')),Array()), 'encq').'';}).'
	</div>

	'.'
	'.LCRun3::hbch($cx, 'progressiveEnhancement', Array(Array(),Array()), $in, function($cx, $in) {return '
		<div class="flow-anon-warning-desktop">
			'.LCRun3::hbch($cx, 'tooltip', Array(Array(),Array('positionClass'=>'left','contextClass'=>'progressive','extraClass'=>'flow-form-collapsible','isBlock'=>true)), $in, function($cx, $in) {return '
				'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-anon-warning',LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin'),Array()), 'raw'),LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin/signup'),Array()), 'raw')),Array()), 'encq').'';}).'
		</div>
	';}).'
</div>
		';}).'

		<textarea id="flow-post-'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'-form-content"
				name="topic_content"
				required
				data-flow-preview-template="flow_post"
				data-flow-expandable="true"
				class="mw-ui-input"
				type="text"
				placeholder="'.LCRun3::ch($cx, 'l10n', Array(Array('flow-reply-topic-title-placeholder',LCRun3::ch($cx, 'plaintextSnippet', Array(Array(((is_array($in['content']) && isset($in['content']['format'])) ? $in['content']['format'] : null),((is_array($in['content']) && isset($in['content']['content'])) ? $in['content']['content'] : null)),Array()), 'raw')),Array()), 'encq').'"
				data-role="content">'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['submitted'])) ? $cx['scopes'][0]['submitted'] : null))) ? ''.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($cx['scopes'][0]['submitted']) && isset($cx['scopes'][0]['submitted']['postId'])) ? $cx['scopes'][0]['submitted']['postId'] : null),'===',((is_array($in) && isset($in['postId'])) ? $in['postId'] : null)),Array()), $in, function($cx, $in) {return ''.htmlentities(((is_array($cx['scopes'][0]['submitted']) && isset($cx['scopes'][0]['submitted']['content'])) ? $cx['scopes'][0]['submitted']['content'] : null), ENT_QUOTES, 'UTF-8').'';}).'' : '').'</textarea>

		<div class="flow-form-actions flow-form-collapsible">
			<button data-role="submit"
			        class="mw-ui-button mw-ui-constructive"
			        data-flow-interactive-handler="apiRequest"
			        data-flow-api-handler="submitReply"
			        data-flow-api-target="< .flow-topic">'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['title'])) ? $in['actions']['reply']['title'] : null), ENT_QUOTES, 'UTF-8').'</button>
			'.LCRun3::hbch($cx, 'progressiveEnhancement', Array(Array(),Array()), $in, function($cx, $in) {return '
	<button data-flow-api-handler="preview"
	        data-flow-api-target="< form textarea"
	        name="preview"
	        data-role="action"
	        class="mw-ui-button mw-ui-progressive mw-ui-quiet mw-ui-flush-right"
	>'.LCRun3::ch($cx, 'l10n', Array(Array('flow-preview'),Array()), 'encq').'</button>

	<button data-flow-interactive-handler="cancelForm"
	        data-role="cancel"
	        type="reset"
	        class="mw-ui-button mw-ui-destructive mw-ui-quiet mw-ui-flush-right"
	>'.LCRun3::ch($cx, 'l10n', Array(Array('flow-cancel'),Array()), 'encq').'</button>
';}).'

			<small class="flow-terms-of-use plainlinks">'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-terms-of-use-reply'),Array()), 'encq').'</small>
		</div>
	</form>
' : '').'

			';}, function($cx, $in) {return '
				'.LCRun3::hbch($cx, 'progressiveEnhancement', Array(Array(),Array('type'=>'replace','target'=>'~ a')), $in, function($cx, $in) {return '
					'.((LCRun3::ifvar($cx, ((is_array($in['actions']) && isset($in['actions']['reply'])) ? $in['actions']['reply'] : null))) ? '
	<form class="flow-post flow-reply-form"
	      method="POST"
	      action="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['url'])) ? $in['actions']['reply']['url'] : null), ENT_QUOTES, 'UTF-8').'"
	      id="flow-reply-'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'"
	      data-flow-initial-state="collapsed"
	>
		<input type="hidden" name="wpEditToken" value="'.htmlentities(((is_array($cx['scopes'][0]['rootBlock']) && isset($cx['scopes'][0]['rootBlock']['editToken'])) ? $cx['scopes'][0]['rootBlock']['editToken'] : null), ENT_QUOTES, 'UTF-8').'" />
		<input type="hidden" name="topic_replyTo" value="'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'" />
		<div class="flow-error-container">
'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null))) ? '
	<div class="flow-errors errorbox">
		<ul>
			'.LCRun3::sec($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['errors'])) ? $cx['scopes'][0]['errors'] : null), $in, true, function($cx, $in) {return '
				<li>'.LCRun3::ch($cx, 'html', Array(Array(((is_array($in) && isset($in['message'])) ? $in['message'] : null)),Array()), 'encq').'</li>
			';}).'
		</ul>
	</div>
' : '').'
</div>


		'.LCRun3::hbch($cx, 'ifAnonymous', Array(Array(),Array()), $in, function($cx, $in) {return '
			<div class="flow-anon-warning">
	<div class="flow-anon-warning-mobile">
		'.'
		'.LCRun3::hbch($cx, 'tooltip', Array(Array(),Array('positionClass'=>'down','contextClass'=>'progressive','extraClass'=>'flow-form-collapsible','isBlock'=>true)), $in, function($cx, $in) {return '
			'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-anon-warning',LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin'),Array()), 'raw'),LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin/signup'),Array()), 'raw')),Array()), 'encq').'';}).'
	</div>

	'.'
	'.LCRun3::hbch($cx, 'progressiveEnhancement', Array(Array(),Array()), $in, function($cx, $in) {return '
		<div class="flow-anon-warning-desktop">
			'.LCRun3::hbch($cx, 'tooltip', Array(Array(),Array('positionClass'=>'left','contextClass'=>'progressive','extraClass'=>'flow-form-collapsible','isBlock'=>true)), $in, function($cx, $in) {return '
				'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-anon-warning',LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin'),Array()), 'raw'),LCRun3::ch($cx, 'linkWithReturnTo', Array(Array('Special:UserLogin/signup'),Array()), 'raw')),Array()), 'encq').'';}).'
		</div>
	';}).'
</div>
		';}).'

		<textarea id="flow-post-'.htmlentities(((is_array($in) && isset($in['postId'])) ? $in['postId'] : null), ENT_QUOTES, 'UTF-8').'-form-content"
				name="topic_content"
				required
				data-flow-preview-template="flow_post"
				data-flow-expandable="true"
				class="mw-ui-input"
				type="text"
				placeholder="'.LCRun3::ch($cx, 'l10n', Array(Array('flow-reply-topic-title-placeholder',LCRun3::ch($cx, 'plaintextSnippet', Array(Array(((is_array($in['content']) && isset($in['content']['format'])) ? $in['content']['format'] : null),((is_array($in['content']) && isset($in['content']['content'])) ? $in['content']['content'] : null)),Array()), 'raw')),Array()), 'encq').'"
				data-role="content">'.((LCRun3::ifvar($cx, ((is_array($cx['scopes'][0]) && isset($cx['scopes'][0]['submitted'])) ? $cx['scopes'][0]['submitted'] : null))) ? ''.LCRun3::hbch($cx, 'ifCond', Array(Array(((is_array($cx['scopes'][0]['submitted']) && isset($cx['scopes'][0]['submitted']['postId'])) ? $cx['scopes'][0]['submitted']['postId'] : null),'===',((is_array($in) && isset($in['postId'])) ? $in['postId'] : null)),Array()), $in, function($cx, $in) {return ''.htmlentities(((is_array($cx['scopes'][0]['submitted']) && isset($cx['scopes'][0]['submitted']['content'])) ? $cx['scopes'][0]['submitted']['content'] : null), ENT_QUOTES, 'UTF-8').'';}).'' : '').'</textarea>

		<div class="flow-form-actions flow-form-collapsible">
			<button data-role="submit"
			        class="mw-ui-button mw-ui-constructive"
			        data-flow-interactive-handler="apiRequest"
			        data-flow-api-handler="submitReply"
			        data-flow-api-target="< .flow-topic">'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['title'])) ? $in['actions']['reply']['title'] : null), ENT_QUOTES, 'UTF-8').'</button>
			'.LCRun3::hbch($cx, 'progressiveEnhancement', Array(Array(),Array()), $in, function($cx, $in) {return '
	<button data-flow-api-handler="preview"
	        data-flow-api-target="< form textarea"
	        name="preview"
	        data-role="action"
	        class="mw-ui-button mw-ui-progressive mw-ui-quiet mw-ui-flush-right"
	>'.LCRun3::ch($cx, 'l10n', Array(Array('flow-preview'),Array()), 'encq').'</button>

	<button data-flow-interactive-handler="cancelForm"
	        data-role="cancel"
	        type="reset"
	        class="mw-ui-button mw-ui-destructive mw-ui-quiet mw-ui-flush-right"
	>'.LCRun3::ch($cx, 'l10n', Array(Array('flow-cancel'),Array()), 'encq').'</button>
';}).'

			<small class="flow-terms-of-use plainlinks">'.LCRun3::ch($cx, 'l10nParse', Array(Array('flow-terms-of-use-reply'),Array()), 'encq').'</small>
		</div>
	</form>
' : '').'

				';}).'
				<a href="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['url'])) ? $in['actions']['reply']['url'] : null), ENT_QUOTES, 'UTF-8').'"
				   title="'.htmlentities(((is_array($in['actions']['reply']) && isset($in['actions']['reply']['title'])) ? $in['actions']['reply']['title'] : null), ENT_QUOTES, 'UTF-8').'"
				   class="flow-ui-input-replacement-anchor mw-ui-input"
				>'.LCRun3::ch($cx, 'l10n', Array(Array('flow-reply-topic-title-placeholder',LCRun3::ch($cx, 'plaintextSnippet', Array(Array(((is_array($in['content']) && isset($in['content']['format'])) ? $in['content']['format'] : null),((is_array($in['content']) && isset($in['content']['content'])) ? $in['content']['content'] : null)),Array()), 'raw')),Array()), 'encq').'</a>
			';}).'
		' : '').'
	' : '').'
</div>

	';}).'
';}).'
	</div>
</div>
';
}
?>