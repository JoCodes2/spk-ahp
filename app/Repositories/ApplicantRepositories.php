<?php

namespace App\Repositories;

use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\PositionRequest;
use App\Interface\ApplicantInterfaces;
use App\Interface\PositionInterfaces;
use App\Models\Applicant;
use App\Models\Position;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class applicantRepositories implements ApplicantInterfaces
{
    use HttpResponseTraits;
    protected $ApplicantModel;
    public function __construct(Applicant $ApplicantModel)
    {
        $this->ApplicantModel = $ApplicantModel;
    }

    public function getAllData()
    {
        $data = $this->ApplicantModel::with('position')->get();
        if (!$data) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }


    public function createData(ApplicantRequest $request)
    {
        try {
            // Create the Applicant
            $data = new $this->ApplicantModel;
            $data->name = $request->input('name');
            $data->code = $request->input('code');
            $data->position_id = $request->input('position_id');


            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->ApplicantModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateData(ApplicantRequest $request, $id)
    {
        try {
            // Cari data berdasarkan ID
            $data = $this->ApplicantModel::where('id', $id)->first();
            if (!$data) {
                return $this->dataNotFound();
            }

            $data->name = $request->input('name');
            $data->code = $request->input('code');
            $data->position_id = $request->input('position_id');

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
            $data = $this->ApplicantModel::findOrFail($id);
            $data->delete();

            return $this->success(['message' => 'Data berhasil dihapus.']);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
