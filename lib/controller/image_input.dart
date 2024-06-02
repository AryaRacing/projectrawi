import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class ImageInput extends StatefulWidget {
  const ImageInput({super.key, required this.onPickImage});

  final void Function(File image) onPickImage;

  @override
  State<StatefulWidget> createState() {
    return _ImageInputState();
  }
}

class _ImageInputState extends State<ImageInput> {
  File? _imagetaken;

  void takePicture() async {
    final imagepicker = ImagePicker();
    final pickedimage =
        await imagepicker.pickImage(source: ImageSource.camera, maxWidth: 1000);

    if (pickedimage == null) {
      return;
    }
    setState(() {
      _imagetaken = File(pickedimage.path);
    });

    widget.onPickImage(_imagetaken!);
  }

  @override
  Widget build(BuildContext context) {
    Widget content = TextButton.icon(
      icon: const Icon(Icons.camera_alt_rounded),
      label: const Text('Ambil Foto'),
      onPressed: takePicture,
    );

    if (_imagetaken != null) {
      content = GestureDetector(
        onTap: takePicture,
        child: Image.file(
          _imagetaken!,
          fit: BoxFit.cover,
          width: double.infinity,
          height: double.infinity,
        ),
      );
    }

    return Container(
      decoration: BoxDecoration(
        border: Border.all(
          width: 1,
          color: Theme.of(context).colorScheme.primary.withOpacity(0.2),
        ),
      ),
      height: 200,
      width: double.infinity,
      alignment: Alignment.center,
      child: content,
    );
  }
}
