<!DOCTYPE html>
<html>

<head>
    <title>{{ $kategori_data['title'] }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<h1>{{ $kategori_data['title'] }}</h1>
<hr>
<p>Kategori: {{ $kategori_data['kategori'] }}</p>
<p>Gudang: {{ $kategori_data['gudang'] }}</p>
<p>Belajar Laravel bersama ChatGPT</p>
<button type="button" onclick="search()">
    Search
</button>
<script>
var url = "{{ route('mutation_review') }}";

function search()
{
    $.ajax({
        url: url,
        method: "GET",
        data:{
            periode: $("#periode").val(),
            gudang: "Gudang Material",
            kategori: "Bahan baku"
        },
        success:function(res){
            console.log("RESPONSE :", res);

    console.log("STATUS :", res.status);
    console.log("COUNT :", res.count);
    console.log("DATA :", res.data);
        },
        error:function(xhr){
            console.log(xhr.responseText);
        }
    });
}
</script>
</body>

</html>