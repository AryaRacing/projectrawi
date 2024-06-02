import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:proyek_akhir/about.dart';
import 'package:proyek_akhir/controller/places_list.dart';
import 'package:proyek_akhir/controller/session.dart';
import 'package:proyek_akhir/login.dart';
import 'package:proyek_akhir/providers/user_places.dart';
import 'package:proyek_akhir/view/add_places.dart';

class PlaceSScreen extends ConsumerStatefulWidget {
  const PlaceSScreen({Key? key}) : super(key: key);

  @override
  ConsumerState<PlaceSScreen> createState() {
    return _PlaceSScreenState();
  }
}

class _PlaceSScreenState extends ConsumerState<PlaceSScreen> {
  late Future<void> _placesFuture;
  final _sessionManager = SessionManager();

  @override
  void initState() {
    super.initState();
    _placesFuture = ref.read(userPlacesProvider.notifier).loadLocation();
  }

  void _logout(BuildContext context) {
    // Hapus data sesi saat logout
    _sessionManager.clearSession();

    // Navigasi ke halaman login
    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (context) => LoginScreen()),
      (Route<dynamic> route) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    final userPlaces = ref.watch(userPlacesProvider);
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tempat Favorit'),
        actions: [
          IconButton(
            icon: const Icon(Icons.add),
            onPressed: () {
              Navigator.of(context).push(
                MaterialPageRoute(
                  builder: (ctx) => const AddPlaceSScreen(),
                ),
              );
            },
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: FutureBuilder(
          future: _placesFuture,
          builder: (context, snapshot) =>
              snapshot.connectionState == ConnectionState.waiting
                  ? const Center(
                      child: CircularProgressIndicator(),
                    )
                  : PlacesList(
                      places: userPlaces,
                    ),
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.info),
            label: 'About',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.logout),
            label: 'Logout',
          ),
        ],
        onTap: (index) {
          if (index == 0) {
            Navigator.of(context).push(
              MaterialPageRoute(
                builder: (ctx) => const AboutScreen(),
              ),
            );
          } else if (index == 1) {
            _logout(context);
          }
        },
      ),
    );
  }
}
