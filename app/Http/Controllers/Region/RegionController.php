<?php

namespace App\Http\Controllers\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\RegionOrganization;
use App\Models\Organization;

class RegionController extends Controller
{
  public function getAll()
  {
    $regions = Region::all();
    $res = [
      'data' => [
        'regions' => $regions
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function add(Request $request)
  {
    $region = new Region;
    $region->name = $request->name;
    $region->save();
    $res = [
      'data' => [
        'region' => $region
      ],
      'status' => 'ok',
    ];

    return response()->json($res)->setStatusCode(201);
  }
  public function change($region, Request $request)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $region->name = $request->name;
    $region->save();

    $res = [
      'data' => [
        'region' => $region
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function delete($region)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $region_organization = RegionOrganization::all()->where('region_id', $region->region_id)->first();
    if ($region_organization) {
      $res = [
        'data' => [
          'error' => 'Регион содержит организации'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(400);
    }
    $region->delete();
    $res = [
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function organizations($region)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $region_organization = RegionOrganization::all()->where('region_id', $region->region_id);
    $res = [
      'data' => [
        'organizations' => []
      ],
      'status' => 'ok',
    ];
    foreach ($region_organization as $organization) {
      $organization = Organization::all()->where('organization_id', $organization->organization_id)->first();
      $res['data']['organizations'][] = $organization->name;
    }
    return response()->json($res)->setStatusCode(200);
  }
  public function getOrganizations($region, Request $request)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }

    $organization = Organization::all()->where('name', $request->name)->first();
    if (!$organization) {
      $organization = new Organization();
      $organization->name = $request->name;
      $organization->save();
    }

    $region_organization = RegionOrganization::all()
      ->where('region_id', $region->region_id)
      ->where('organization_id', $organization->organization_id)
      ->first();
    if (!$region_organization) {
      $region_organization = new RegionOrganization();
      $region_organization->region_id = $region->region_id;
      $region_organization->organization_id = $organization->organization_id;
      $region_organization->save();
    }

    $res = [
      'data' => [
        'organization' => $organization
      ],
      'status' => 'ok',
    ];

    return response()->json($res)->setStatusCode(200);
  }
  public function changeOrganizations($region, $organization, Request $request)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $region_organizations = RegionOrganization::all()
      ->where('region_id', $region->region_id);
    if (!$region_organizations) {
      $res = [
        'data' => [
          'error' => 'Организация не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $organizationSave = $organization;
    foreach ($region_organizations as $region_organization) {
      $organization = Organization::all()
        ->where('organization_id', $region_organization->organization_id)
        ->where('name', $organizationSave)
        ->first();
      if ($organization) {
        $organization->name = $request->name;
        $organization->save();

        $res = [
          'data' => [
            'organization' => $organization
          ],
          'status' => 'ok',
        ];
        return response()->json($res)->setStatusCode(200);
      }
    }
    $res = [
      'data' => [
        'error' => 'Организация не найдена'
      ],
      'status' => 'error',
    ];
    return response()->json($res)->setStatusCode(404);
  }
  public function deleteOrganizations($region, $organization, Request $request)
  {
    $region = Region::all()->where('name', $region)->first();
    if (!$region) {
      $res = [
        'data' => [
          'error' => 'Регион не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }

    $region_organizations = RegionOrganization::all()
      ->where('region_id', $region->region_id);
    if (!$region_organizations) {
      $res = [
        'data' => [
          'error' => 'Организация не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $organizationSave = $organization;
    foreach ($region_organizations as $region_organization) {
      $organization = Organization::all()
        ->where('organization_id', $region_organization->organization_id)
        ->where('name', $organizationSave)
        ->first();
      if ($organization) {
        $organization->delete();

        $res = [
          'status' => 'ok',
        ];
        return response()->json($res)->setStatusCode(200);
      }
    }
    $res = [
      'data' => [
        'error' => 'Организация не найдена'
      ],
      'status' => 'error',
    ];
    return response()->json($res)->setStatusCode(404);
  }
}
