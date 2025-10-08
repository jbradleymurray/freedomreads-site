<?php

return function ($site) {

  $query   = get('q');
  $map = page('map')->children();
  $scope = $site->index()->listed()->not($map);
  $results = $scope->bettersearch($query, ['fields' => ['title','introduction','blocks','listing', 'newstags', 'bio']]);
  return [
    'query'      => $query,
    'results'    => $results->sortBy('published', 'desc')
  ];

};