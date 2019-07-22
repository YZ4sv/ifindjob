public class AnimalUtil {
    enum AnimalType {Bird, Dog, Cat, Elephant, Rhino, Lion, Squirrel}

    static class Animal {
        AnimalType animalType;

        // тут должно быть объявление метода arrangeAnimalsAmongRooms, но я о нём забыл
    }

    enum RoomType {Hall, Bedroom, Bathroom, Balcony}

    static class RoomFindConfig {
        public RoomType type;
        public float animalCapacity;

        public void RoomFindConfig(RoomType _type, float _animalCapacity) {
            type = _type;
            animalCapacity = _animalCapacity;
        }
    }

    static class Room {
        int capacity;
        RoomType roomType;

        public static bool findRoom(Room[] rooms, RoomFindConfig findConfig) {
            for (int j = 0; j < rooms.length; j++) {
                if (rooms[j].roomType == findConfig.type && rooms[j].capacity != 0) {
                    rooms[j].capacity -= findConfig.animalCapacity;

                    return true;
                }
            }

            return false;
        }

        public static void findRoomWithException(Room[] rooms, RoomFindConfig findConfig, String exceptionMessage) {
            if (!this.findRoom(rooms, findConfig)) {
                throw new IllegalArgumentException(exceptionMessage);
            }
        }
    }

    static class Bird extends Animal {
        AnimalType animalType = AnimalType.Bird;

        public void arrangeAnimalsAmongRooms(Room[] rooms) {
            RoomFindConfig findConfig = new RoomFindConfig(RoomType.Hall, 0.25);
            Room.findRoom(rooms, findConfig);
        }
    }

    static class Dog extends Animal {
        AnimalType animalType = AnimalType.Dog;

        public void arrangeAnimalsAmongRooms(Room[] rooms) {
            RoomFindConfig findConfig = new RoomFindConfig(RoomType.Hall, 0.4);
            Room.findRoomWithException(rooms, findConfig, "Dog(s) can be arranged");
        }
    }

    static class Elephant extends Animal {
        AnimalType animalType = AnimalType.Elephant;

        public void arrangeAnimalsAmongRooms(Room[] rooms) {
            RoomFindConfig findConfig = new RoomFindConfig(RoomType.Balcony, 0.6);
            if (Room.findRoom(rooms, findConfig)) {    
                System.out.println("A new elephant just arrived");
            }
        }
    }

    static class Rhino extends Animal {
        AnimalType animalType = AnimalType.Rhino;

        public void arrangeAnimalsAmongRooms(Room[] rooms) {
            RoomFindConfig findConfig = new RoomFindConfig(RoomType.Bedroom, 0.6);
            Room.findRoomWithException(rooms, findConfig, "Rhinos(s) can be arranged");
        }
    }

    static void arrangeAnimalsAmongRooms(Animal[] animals, Room[] rooms) {
        for (int i = 0; i < animals.length; i++) {
            Animal.arrangeAnimalsAmongRooms(rooms);
        }
    }
}
