<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c_comments = [];
        $users = User::all();
        $products = Product::all();
        foreach ($users as $user) {
            foreach ($products as $product) {
                $count_comments = rand(1, 10);
                for ($i = 0; $i < $count_comments; $i++) {
                    $comment = new Comment;
                    $comment->fill([
                        'grade' => rand(0, 5),
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'text' => Str::random(10)
                    ]);
                    $c_comments[] = $comment;
                }
            }
        }
        $comments = collect($c_comments);
        DB::transaction (function () use ($comments) {
            $comments->each(function ($n_comment) { $n_comment->save(); });
        });
    }
}
