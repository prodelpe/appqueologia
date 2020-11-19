@csrf

<div class="form-group">
    <label for="codi"><strong>Codi</strong></label>
    <input type="text" class="form-control" id="codi" name="codi" value="{{ isset($excavacio) ? $excavacio->codi : '' }}" placeholder="Introdueix el codi" />
</div>

<div class="form-group">
    <label for="nom"><strong>Nom</strong></label>
    <input type="text" class="form-control" id="nom" name="nom" value="{{ isset($excavacio) ? $excavacio->nom : '' }}" placeholder="Introdueix el nom" />
</div>

<div class="form-group">
    <label for="codi"><strong>Població</strong></label>
    <input type="text" class="form-control" id="poblacio" name="poblacio" value="{{ isset($excavacio) ? $excavacio->poblacio : '' }}" placeholder="Introdueix la població" />
</div>
