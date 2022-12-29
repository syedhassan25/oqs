<?php

use App\models\Student;
use App\models\Student_Comment_History;
use App\models\Student_Follow_Up_Comments;
use App\models\Task;
use App\models\TaskComment;
use Illuminate\Database\Seeder;

class TimeLineLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasklist = Task::get();

        foreach ($tasklist as $taskdata) {

            $relateType = "student";
            if ($taskdata->task_assign_type == 1) {
                $relateType = "other";
            }
            timeLineLogCreate($taskdata->taskName, $taskdata->taskDescription, $taskdata, 'task', 'task', $taskdata->id, $relateType, $taskdata->multi_student, $taskdata->multi_student_group, $taskdata->created_by, $taskdata->created_at, $taskdata->updated_at);
        }

        $CommentHistorylist = Student_Comment_History::get();

        foreach ($CommentHistorylist as $CommentHistorydata) {

            $student = Student::find($CommentHistorydata->studentId);
            timeLineLogCreate($CommentHistorydata->comment, '', $CommentHistorydata, 'student', 'comment-history', $CommentHistorydata->id, 'student', $CommentHistorydata->studentId, ($student) ? $student->group : '', $CommentHistorydata->created_by, $CommentHistorydata->created_at, $CommentHistorydata->updated_at);
        }

        $CommentHistorylists = Student_Follow_Up_Comments::get();

        foreach ($CommentHistorylist as $CommentHistorydata) {

            $student = Student::find($CommentHistorydata->studentId);
            timeLineLogCreate($CommentHistorydata->comment, '', $CommentHistorydata, 'student', 'follow-comment', $CommentHistorydata->id, 'student', $CommentHistorydata->studentId, ($student) ? $student->group : '', $CommentHistorydata->created_by, $CommentHistorydata->created_at, $CommentHistorydata->updated_at);
        }

        $TaskCommentlists = TaskComment::get();

        foreach ($TaskCommentlists as $TaskCommentdata) {

            timeLineLogCreate($TaskCommentdata->comment, '', $TaskCommentdata, 'task', 'task-comment', $TaskCommentdata->id, 'task', $TaskCommentdata->taskId, '', $TaskCommentdata->userId, $TaskCommentdata->created_at, $TaskCommentdata->updated_at);
        }
    }

}
