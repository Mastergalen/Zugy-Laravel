<?php

namespace Zugy\ActivityLogParser;

use Illuminate\Database\Eloquent\Collection;

class ActivityLogParser
{
    public function order(Collection $activity) {
        $return = [];

        foreach($activity as $a) {
            switch($a->action) {
                case 'status-change':
                    $status = trans('order.status.' . $a->description);
                    $description = trans('activityLogParser/order.status-changed', ['status' => $status]);
                    $title = $status;
                    $type = $this->getOrderStatusType($a->description);
                    $icon  = $this->getOrderStatusIcon($a->description);
                    break;

                case 'create':
                    $type = '';
                    $description = trans('activityLogParser/order.create');
                    $title = $description;
                    $icon = 'navicon';
                    break;
                default:
                    throw new \Exception("Activity action does not exist");
            }

            $return[] = [
                'user' => $a->user,
                'timestamp' => $a->created_at,
                'title' => $title,
                'description' => $description,
                'type' => $type,
                'icon' => $icon,
            ];
        }

        return $return;
    }

    private function getOrderStatusType($statusId)
    {
        switch($statusId) {
            case 1:
                return 'warning';
            case 2:
                return 'primary';
            case 3:
                return 'success';
            case 4:
                return 'danger';
            default:
                return '';
        }
    }

    private function getOrderStatusIcon($statusId)
    {
        switch($statusId) {
            case 1:
                return 'ellipsis-h';
            case 2:
                return 'truck';
            case 3:
                return 'check';
            case 4:
                return 'times';
            default:
                return 'check';
        }
    }
}