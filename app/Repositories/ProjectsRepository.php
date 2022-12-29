<?php

namespace App\Repositories;

use App\Interfaces\ProjectsRepositoryInterface;
use App\Models\Projects;

class ProjectsRepository implements ProjectsRepositoryInterface 
{
    public function getAllProjects() 
    {
        return Projects::all();
    }

    public function getProjectById($projectId) 
    {
        return Projects::findOrFail($projectId);
    }

    public function deleteProject($projectId) 
    {
        Projects::destroy($projectId);
    }

    public function createProject(array $projectDetails) 
    {
        return Projects::create($projectDetails);
    }

    public function updateProject($projectId, array $newDetails) 
    {
        return Projects::whereId($projectId)->update($newDetails);
    }

    public function getFulfilledProjects() 
    {
        return Projects::where('is_fulfilled', true);
    }
}
