<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DogController extends Controller
{
    public function store(Request $request)
    {
        $daten = $request->validate([
            "name" => "required|string",
            "birth_date" => "required|date",
            "weight_kg" => "required|numeric",
            "size_cm" => "required|integer",
            "tollwut_impfung" => "required|boolean",
            "breed" => "required|string",
            "description" => "required|string",
            "dog_file" => "nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:10240",
        ]);

        unset($daten["dog_file"]);

        $path = null;

        try {
            DB::transaction(function () use ($request, $daten, &$path) {
                $dogId = DB::table("raw.dogs")->insertGetId($daten);

                if ($request->hasFile("dog_file")) {
                    $file = $request->file("dog_file");
                    $path = $file->store("dogs", "public");

                    if (!$path) {
                        throw new \RuntimeException("Datei konnte nicht gespeichert werden.");
                    }

                    DB::table("raw.dog_files")->insert([
                        "dog_id" => $dogId,
                        "file_path" => $path,
                        "file_type" => $file->getMimeType(),
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            if ($path) {
                Storage::disk("public")->delete($path);
            }

            throw $exception;
        }

        return redirect("/create");
    }

    public function load(Request $request)
    {
        $daten = DB::table("raw.dogs")->get();
        $daten_files = DB::table("raw.dog_files")->get();

        return view("create", [
            "daten" => $daten,
            "daten_files" => $daten_files,
        ]);
    }

    public function edit(Request $request)
    {
        $daten = $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "birth_date" => "required|date",
            "weight_kg" => "required|numeric",
            "size_cm" => "required|integer",
            "tollwut_impfung" => "required|boolean",
            "breed" => "required|string",
            "description" => "required|string",
            "dog_file" => "nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:10240",
        ]);

        $dogId = (int) $daten["id"];

        unset($daten["id"], $daten["dog_file"]);

        $newPath = null;
        $oldPaths = [];

        try {
            DB::transaction(function () use (
                $request,
                $daten,
                $dogId,
                &$newPath,
                &$oldPaths
            ) {
                DB::table("raw.dogs")
                    ->where("id", $dogId)
                    ->update($daten);

                if ($request->hasFile("dog_file")) {
                    $file = $request->file("dog_file");
                    $newPath = $file->store("dogs", "public");

                    if (!$newPath) {
                        throw new \RuntimeException("Datei konnte nicht gespeichert werden.");
                    }

                    // Ein neues Foto ersetzt bisherige Fotos.
                    // Andere Dokumente bleiben erhalten.
                    if (str_starts_with($file->getMimeType(), "image/")) {
                        $oldPaths = DB::table("raw.dog_files")
                            ->where("dog_id", $dogId)
                            ->where("file_type", "like", "image/%")
                            ->pluck("file_path")
                            ->all();

                        DB::table("raw.dog_files")
                            ->where("dog_id", $dogId)
                            ->where("file_type", "like", "image/%")
                            ->delete();
                    }

                    DB::table("raw.dog_files")->insert([
                        "dog_id" => $dogId,
                        "file_path" => $newPath,
                        "file_type" => $file->getMimeType(),
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            if ($newPath) {
                Storage::disk("public")->delete($newPath);
            }

            throw $exception;
        }

        if (!empty($oldPaths)) {
            Storage::disk("public")->delete($oldPaths);
        }

        return redirect("/create");
    }

    public function delete(Request $request)
    {
        $daten = $request->validate([
            "id" => "required|integer",
        ]);

        $dogId = (int) $daten["id"];

        $filePaths = DB::transaction(function () use ($dogId) {
            $filePaths = DB::table("raw.dog_files")
                ->where("dog_id", $dogId)
                ->pluck("file_path")
                ->all();

            DB::table("raw.dog_files")
                ->where("dog_id", $dogId)
                ->delete();

            DB::table("raw.feeding_day")
                ->where("dog_id", $dogId)
                ->delete();

            DB::table("raw.dogs")
                ->where("id", $dogId)
                ->delete();

            return $filePaths;
        });

        if (!empty($filePaths)) {
            Storage::disk("public")->delete($filePaths);
        }

        return redirect("/create");
    }
}
