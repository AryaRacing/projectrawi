import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:location/location.dart';
import 'package:proyek_akhir/controller/image_input.dart';
import 'package:proyek_akhir/controller/locationAPI.dart';
import 'package:proyek_akhir/model/placeBE.dart';
import 'package:proyek_akhir/providers/user_places.dart';
import 'dart:io';

class AddPlaceSScreen extends ConsumerStatefulWidget {
  const AddPlaceSScreen({super.key});

  @override
  ConsumerState<AddPlaceSScreen> createState() {
    return _AddPlaceScreensState();
  }
}

class _AddPlaceScreensState extends ConsumerState<AddPlaceSScreen> {
  final _titleController = TextEditingController();
  File? _imagetaken;
  PlaceLocation? _selectedLocation;

  void _savePlace() {
    final enteredTitle = _titleController.text;

    if (enteredTitle.isEmpty ||
        _imagetaken == null ||
        _selectedLocation == null) {
      return;
    }

    ref
        .read(userPlacesProvider.notifier)
        .addPlace(enteredTitle, _imagetaken!, _selectedLocation!);

    Navigator.of(context).pop;
  }

  @override
  void dispose() {
    _titleController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tambah Tempat baru'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(12),
        child: Column(
          children: [
            TextField(
              decoration: InputDecoration(labelText: 'Nama Tempat'),
              controller: _titleController,
              style:
                  TextStyle(color: Theme.of(context).colorScheme.onBackground),
            ),
            const SizedBox(height: 20),
            ImageInput(
              onPickImage: (image) {
                _imagetaken = image;
              },
            ),
            const SizedBox(height: 20),
            LocationInput(
              onSelectedLocation: (location) {
                _selectedLocation = location;
              },
            ),
            const SizedBox(height: 20),
            ElevatedButton.icon(
              onPressed: _savePlace,
              icon: const Icon(Icons.add),
              label: const Text('Tambah Tempat'),
            ),
          ],
        ),
      ),
    );
  }
}
