<?php

namespace App\Enums;

enum TaskStatus: string
{
    case TO_DO = 'to_do';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    /**
     * Get the human-readable label for each task status.
     * 
     * This method returns the label of the task status in a more readable format
     * like "To-Do", "In Progress", and "Done".
     *
     * @return string The label of the current task status.
     */
    public function label(): string
    {
        return match($this) {
            self::TO_DO => 'To-Do',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }

    /**
     * Get the Tailwind CSS background color class for each task status.
     * 
     * This method maps each task status to a specific Tailwind background color class,
     * such as 'bg-blue-500', 'bg-yellow-500', and 'bg-green-500'.
     *
     * @return string The background color class for the current task status.
     */
    public function color(): string
    {
        return match($this) {
            self::TO_DO => 'bg-blue-500',
            self::IN_PROGRESS => 'bg-yellow-500',
            self::DONE => 'bg-green-500',
        };
    }

    /**
     * Get all task statuses with their name, value, and label.
     * 
     * This static method returns an array of all task statuses with additional
     * information such as the `name`, `value`, and `label` for each enum case.
     * It is particularly useful for populating dropdowns or displaying
     * all statuses in the application.
     *
     * @return array An array of task statuses with 'name', 'value', and 'label'.
     */
    public static function values(): array
    {
        return array_map(fn($status) => [
            'name'  => $status->name,
            'value' => $status->value,
            'label' => $status->label(),
        ], self::cases());
    }
}

