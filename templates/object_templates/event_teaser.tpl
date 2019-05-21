{EVAL}
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Parser;
use Jakobus\Event;


$al = new PsrAutoloader();
$al->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');
$al->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

if (!empty($cmtContentData['head1'])) {
	$eventId = (int)$cmtContentData['head1'];
}

$Event = new Event();

$events = $Event->findAll();
$eventsSelectOptions = '';
foreach ($events as $event) {
	$eventsSelectOptions .= sprintf('<option value="%s" %s>%s</option>', $event['id'], ($event['id'] == $eventId) ? 'selected' : '', $event['event_title']);
}

if (!empty($eventId)) {
	$event = $Event->findById($eventId);
	$Parser = new Parser();
	$Parser->setMultipleParserVars($event);
	$Parser->setParserVar('host', $_SERVER['SERVER_NAME']);
	$eventTeaserContent = $Parser->parseTemplate(PATHTOWEBROOT . "templates/events/newsletter_teaser.tpl");
}

{ENDEVAL}

{IF({LAYOUTMODE})}

<select id="event-teaser-select-{UNIQUEID:new}" onchange="javascript:document.getElementById('event-teaser-input-{UNIQUEID}').innerHTML = this.value">
	{USERVAR:eventsSelectOptions}
</select>

<div id="event-teaser-input-{UNIQUEID}">{HEAD:1}</div>

{ENDIF}

{USERVAR:eventTeaserContent}
