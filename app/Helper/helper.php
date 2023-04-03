<?php


function log_event($eventName, $data = [], $table = null, $key = null, $event_id = null) {

    $event = new App\Models\Logs();
    $event->user_id = auth()->id();
    $event->event = $eventName;
    $event->context = json_encode($data);
    $event->table = $table;
    $event->key = $key;
    $event->IP = request()->ip();

    $event->save();

    return $event->id;
}

function log_error_message(\Exception $ex) {
    logger()->error($ex->getFile() . ':' . $ex->getLine() . '-' . $ex->getMessage());
}

/**
 * Return success response
 *
 * @param string $message
 * @param string $url
 * @return \Illuminate\Http\JsonResponse
 */
function json_response($message , $url =''){
      return response()->json(['message' => $message , 'url' => $url]);
}

/**
 * Return error response
 *
 * @param string $message
 * @return \Illuminate\Http\JsonResponse
 */
function json_error($message) {

    return response()->json(['message' => $message], 422);
}

?>