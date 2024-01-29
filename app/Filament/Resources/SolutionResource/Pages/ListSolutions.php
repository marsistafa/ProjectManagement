<?php

namespace App\Filament\Resources\SolutionResource\Pages;

use App\Filament\Resources\SolutionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Solution;
use App\Models\Project;
use Illuminate\Support\Facades\DB;


class ListSolutions extends ListRecords
{
    protected static string $resource = SolutionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
    public function getTableQuery(): Builder
    {

        $subQuery = DB::table('request_for_quotations')
        ->select('solution_id', DB::raw('COUNT(1) as rfq_count'),
                    DB::raw('concat(SUM(total_excl_tax), " ALL") as total_excl_tax'),
                    DB::raw('concat(SUM(total_incl_tax), " ALL") as total_incl_tax') ) 
        ->where('is_approved', 1)
        ->groupBy('solution_id'); 

        return Solution::query()
        ->join('projects', 'solutions.project_id', '=', 'projects.id')
        ->leftJoinSub($subQuery, 'rfq', function ($join) {
            $join->on('solutions.id', '=', 'rfq.solution_id');  
        })
        ->select('solutions.*', 'solutions.name as solution_name', 'projects.name as name', 'rfq.rfq_count as rfq_count', 'total_excl_tax','total_incl_tax')  
        ->when(request()->has('solution_id'), function ($query) {
            $query->where('solutions.project_id', request('solution_id'));
        });
       
    }
}
