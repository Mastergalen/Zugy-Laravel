<div class="form-group">
    <label for="name">Product title</label>
    {!! Form::text("meta[{$l['code']}][title]", Input::old("meta[{$l['code']}][title]"), ['class' => 'form-control', 'placeholder' => 'Product title']) !!}
</div>
<div class="form-group">
    <label for="">Description</label>
    <div class="summernote">
        <h3>Lorem Ipsum is simply</h3>
        dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been
            the industry's</strong> standard dummy text ever since the 1500s,
        when an unknown printer took a galley of type and scrambled it to make a type
        specimen book. It has survived not only five centuries, but also the leap into
        electronic
        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
        with
        <br/>
        <br/>
        <ul>
            <li>Remaining essentially unchanged</li>
            <li>Make a type specimen book</li>
            <li>Unknown printer</li>
        </ul>
    </div>
</div>
<div class="form-group">
    <label for="meta_description">Meta description</label>
    <span class="help-text">This is the description that will appear on search engine listings.</span>
    {!! Form::text("meta[{$l['code']}][meta_description]", Input::old("meta[{$l['code']}][meta_description]"), ['class' => 'form-control', 'placeholder' => 'Meta description']) !!}
</div>