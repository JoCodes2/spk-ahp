<?php

namespace App\Repositories;

use App\Http\Requests\PositionRequest;
use App\Interface\PositionInterfaces;
use App\Models\Position;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PositionRepositories implements PositionInterfaces
{
    use HttpResponseTraits;
    protected $PositionModel;
    public function __construct(Position $PositionModel)
    {
        $this->PositionModel = $PositionModel;
    }

    public function getAllData()
    {
        $data = $this->PositionModel::all();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }

    public function createData(PositionRequest $request)
    {
        try {
            // Create the Position
            $data = new $this->PositionModel;
            $data->name = $request->input('name');

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->PositionModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateData(PositionRequest $request, $id)
    {
        try {
            // Cari data berdasarkan ID
            $data = $this->PositionModel::where('id', $id)->first();
            if (!$data) {
                return $this->dataNotFound();
            }

            $data->name = $request->input('name');

            // Simpan perubahan
            $data->update();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }


    public function deleteData($id)
    {
        try {
            // Temukan data produk berdasarkan ID
            $data = $this->PositionModel::findOrFail($id);
            $data->delete();

            return $this->success(['message' => 'Data berhasil dihapus.']);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
