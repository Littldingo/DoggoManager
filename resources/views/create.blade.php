<!DOCTYPE>
<html lang="de">
<meta charset="utf-8">

<head>
    @vite(['resources/js/app.js', 'resources/css/app.css'])


    <title>Doggo-Manager</title>
</head>

<body>
    <h1>Create Dog</h1>
    <div id="gesamt">
        <div id="block">
            <form id="dogform" class="card" method="POST" action="/dogs" enctype="multipart/form-data">
                @csrf
                <input type="number" name="id" id="id" style="display: none ">
                <input type="text" name="name" id="name" placeholder="Name">
                <input type="date" name="birth_date" id="birth_date" placeholder="Date of Birth">
                <input type="number" step="0.1" name="weight_kg" id="weight_kg" placeholder="Weight">
                <input type="number" name="size_cm" id="size_cm" placeholder="Size">
                <div id="geimpft">
                    <p id="frage">Is the dog vaccinated against rabies?</p>
                    <label>Yes
                        <input type="radio" name="tollwut_impfung" value="1">
                    </label>
                    <label>No
                        <input type="radio" name="tollwut_impfung" value="0">
                    </label>
                </div>
                <input type="text" name= "breed" id="breed" placeholder="Breed">
                <textarea maxlength="200" rows="5" id="description" cols="40" name="description"
                    placeholder="Describe the dog"></textarea>
                <p id='zeichenanzahl'></p>
                <input type=file id="dog_file" name="dog_file">
                <button id="save" class= "button" type="submit">Save</button>
                <button id="buttonDel" class="deleteButton button" name=deleteButton type="button">Delete</button>
            </form>
        </div>
        <div class= "card" id="showDog">
            <table id="doggoTable">
                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Weight</th>
                    <th>Size</th>
                    <th>Vaccated</th>
                    <th>Breed</th>
                    <th>Description</th>
                </thead>
                <tbody>

                    @foreach ($daten as $dog)
                        <tr>
                                <td>
                            <label>
                                    <input style="display: none" id="dog-{{ $dog->id }}" name="selector" class="checked" type="radio" value={{ $dog->id }}
                                        data-id = "{{ $dog->id }}" 
                                        data-name="{{ $dog->name }}"
                                        data-birth_date="{{ $dog->birth_date }}" 
                                        data-weight_kg="{{ $dog->weight_kg }}"
                                        data-size_cm="{{ $dog->size_cm }}"
                                        data-tollwut_impfung="{{ $dog->tollwut_impfung }}"
                                        data-breed="{{ $dog->breed }}" 
                                        data-description="{{ $dog->description }}">
                                
                             @foreach($daten_files as $dogFiles)                                        
                                @if($dogFiles->dog_id == $dog->id)                            
                                <img class="doggoPic" width="100px" height="auto" src="{{ asset('storage/' . $dogFiles->file_path) }}" alt="{{$dog->name}}">
                                @endif
                            @endforeach
                            </label>
                            </td>
                            <td class="letters"><a href="feed/{{$dog->id}}">{{ $dog->name }}</a></td>
                            <td class="number">{{ $dog->birth_date }}</td>
                            <td class="number">{{ $dog->weight_kg }}</td>
                            <td class="number">{{ $dog->size_cm }}</td>
                            <td class="letters">
                                @if ($dog->tollwut_impfung)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td class="letters">{{ $dog->breed }}</td>
                            <td id="beschreibung">{!! Str::markdown($dog->description, [
                                'html_input' => 'strip',
                                'allow_unsafe_links' => false,
                            ]) !!}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
</body>

</html>
