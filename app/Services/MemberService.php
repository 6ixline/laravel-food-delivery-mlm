<?php

namespace App\Services;

use App\DTO\MemberRequestDTO;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class MemberService{
    public function createMember(Request $request,MemberRequestDTO $requestDTO){
        
        try {
            if ($request->hasFile('kycdoc')) {
                $kycDocs = [];
                foreach ($request->file('kycdoc') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $kycDocs[] = $filename;
                }
                $requestDTO->kycdoc = json_encode($kycDocs);
            }
    
            if ($request->hasFile('panImage')) {
                $panImages = [];
                foreach ($request->file('panImage') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $panImages[] = $filename;
                }
                $requestDTO->panImage = json_encode($panImages);
            }
    
            if ($request->hasFile('bankdoc')) {
                $bankDocs = [];

                foreach ($request->file('bankdoc') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $bankDocs[] = $filename;
                }
                $requestDTO->bankdoc = json_encode($bankDocs);
            }
    
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }

            
            $members = $this->generateMembershipid();
            $sponsorMember = Member::where("membership_id", $requestDTO->sponsor_id)->first();
            if(!$sponsorMember){
                throw new Exception("Invalid Sponsor ID");
            }
            
            $member = Member::create([
                "membership_id"=> $members[0],
                'membership_id_value'=> $members[1],
                'sponsor_id'=> $requestDTO->sponsor_id,
                'sponsor_name'=> $sponsorMember->name,
                'planid'=> 0,
                'rewardid'=> 0,
                'name'=> $requestDTO->name,
                'father_name'=> $requestDTO->father_name,
                'username' => $members[0],
                'relation_name'=> $requestDTO->relation_name,
                'date_of_birth'=> $requestDTO->date_of_birth,
                'gender' => $requestDTO->gender,
                "email"=> $requestDTO->email,
                "password"=> Hash::make("K3K" . substr($requestDTO->mobile, 0, 4)),
                "password_text"=> "K3K" . substr($requestDTO->mobile, 0, 4),
                "mobile"=> $requestDTO->mobile,
                'mobile_alter' => $requestDTO->mobile_alter,
                'address' => $requestDTO->address,
                'pincode' => $requestDTO->pincode,
                'nominee_name' => $requestDTO->nominee_name,
                'kycdoc' => $requestDTO->kycdoc,
                'panImage' => $requestDTO->panImage,
                'bankdoc' => $requestDTO->bankdoc,
                'nominee_relation' => $requestDTO->nominee_relation,
                'nominee_age' => $requestDTO->nominee_age,
                'bank_name' => $requestDTO->bank_name,
                'branch_name' => $requestDTO->branch_name,
                'account_number' => $requestDTO->account_number,
                'ifsc_code' => $requestDTO->ifsc_code,
                'account_name' => $requestDTO->account_name,
                'pan_card' => $requestDTO->pan_card,
                'aadhar_card' => $requestDTO->aadhar_card,
                'imgName' => $requestDTO->imgName,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $member;
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateMember(Request $request,MemberRequestDTO $requestDTO){
        try {
            if ($request->hasFile('kycdoc')) {
                $kycDocs = json_decode($request->old_kycdoc,true);;
                foreach ($request->file('kycdoc') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $kycDocs[] = $filename;
                }
                $requestDTO->kycdoc = json_encode($kycDocs);
            }else{
                $requestDTO->kycdoc = $request->old_kycdoc;
            }
    
            if ($request->hasFile('panImage')) {
               
                $panImages = json_decode($request->old_panImage,true);
                foreach ($request->file('panImage') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $panImages[] = $filename;
                }
                $requestDTO->panImage = json_encode($panImages);
            }else{
                $requestDTO->panImage = $request->old_panImage;
            }
    
            if ($request->hasFile('bankdoc')) {
                $bankDocs = json_decode($request->old_bankdoc, true);

                foreach ($request->file('bankdoc') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);
                    $bankDocs[] = $filename;
                }
                $requestDTO->bankdoc = json_encode($bankDocs);
            }else{
                $requestDTO->bankdoc = $request->old_bankdoc;
            }
    
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }else{
                $requestDTO->imgName = $request->old_imgName;
            }

            $member = Member::where('membership_id', $requestDTO->membership_id)->firstOrFail();
            $updateData = [
                'sponsor_id' => $requestDTO->sponsor_id,
                'sponsor_name' => $requestDTO->sponsor_name,
                'name' => $requestDTO->name,
                'father_name' => $requestDTO->father_name,
                'relation_name' => $requestDTO->relation_name,
                'date_of_birth' => $requestDTO->date_of_birth,
                'gender' => $requestDTO->gender,
                'email' => $requestDTO->email,
                'mobile' => $requestDTO->mobile,
                'mobile_alter' => $requestDTO->mobile_alter,
                'address' => $requestDTO->address,
                'pincode' => $requestDTO->pincode,
                'nominee_name' => $requestDTO->nominee_name,
                'kycdoc' => $requestDTO->kycdoc,
                'panImage' => $requestDTO->panImage,
                'bankdoc' => $requestDTO->bankdoc,
                'nominee_relation' => $requestDTO->nominee_relation,
                'nominee_age' => $requestDTO->nominee_age,
                'bank_name' => $requestDTO->bank_name,
                'branch_name' => $requestDTO->branch_name,
                'account_number' => $requestDTO->account_number,
                'ifsc_code' => $requestDTO->ifsc_code,
                'account_name' => $requestDTO->account_name,
                'pan_card' => $requestDTO->pan_card,
                'aadhar_card' => $requestDTO->aadhar_card,
                'imgName' => $requestDTO->imgName,
                'remarks' => $requestDTO->remarks,
                'status' => $requestDTO->status ?? $member->status
            ];

            if (!empty($requestDTO->password)) {
                $updateData['password'] = Hash::make($requestDTO->password);
                $updateData['password_text'] = $requestDTO->password;
            }

            $member->update($updateData);

            return $member->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteMemberByIds($memberIds = [])
    {
        try {
            if (is_array($memberIds) && count($memberIds) > 0) {
                Member::whereIn('id', $memberIds)->delete();
            } else {
                throw new Exception('No members selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteMember($memberId){
        try {
            $member = Member::find($memberId);
            if (!$member) {
                throw new Exception('Member not found.');
            }
            $member->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function generateMembershipid(){
        $membership_id_value = Member::max('membership_id_value') ?? 0;
        $membership_id_value = $membership_id_value + 1;
        $membership_id = sprintf("%03d", $membership_id_value);
        $membership_id = "K3K" . $membership_id;
        return [$membership_id, $membership_id_value];
    }
}