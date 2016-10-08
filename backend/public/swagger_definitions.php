<?php

/**
 * @SWG\Definition(
 * 	    definition="ArrayObservationSuccess",
 * 		required={"status", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Observation"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleObservationSuccess",
 * 		required={"status", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Observation")
 * 	 )
 *
 *
 * @SWG\Definition(
 * 	    definition="PostBody",
 *      type="object",
 * 		required={"user_1", "categories", "tool", "toolParams", "observations"},
 *		@SWG\Property(property="user_1",type="object", ref="#/definitions/User"),
 *		@SWG\Property(property="user_2",type="object", ref="#/definitions/User"),
 *		@SWG\Property(property="categories", type="array",
 *          @SWG\Items(
 *                 type="string",
 *                 name="Category ID"
 *             )
 *       ),
 *		@SWG\Property(property="tool", type="object", ref="#/definitions/Tool"),
 *		@SWG\Property(property="observations", type="string"),
 *		@SWG\Property(property="implications", type="string"),
 *		@SWG\Property(property="files", type="array", 
 *          @SWG\Items(
 *                 type="string",
 *                 name="URL"
 *             )
 *      )
 * 	 )
 */

/**
 *
 * @SWG\Parameter(
 * 	    name="isbn",
 *      in="path",
 *      description="a Book ISBN",
 * 		required=true,
 *		type="string",
 *      default="1-2222-3333-4"
 * 	 )
 *
*/