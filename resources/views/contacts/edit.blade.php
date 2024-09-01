
    <div class="container">
        <h1>Edit Contact</h1>

        <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $contact->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $contact->email }}" required>
            </div>
            <div class="form-group">
                <label for="subject">Phone</label>
                <input type="text" name="subject" id="subject" class="form-control" value="{{ $contact->subject }}">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="description" id="description" class="form-control">{{ $contact->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

