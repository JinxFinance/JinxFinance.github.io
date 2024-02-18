# import os
import numpy as np
# import tensorflow as tf
from flask import Flask, request, jsonify
import math
# import pandas_datareader as web  # types: import
import datetime as dt
# import pandas as pd
# import sklearn.preprocessing as skp
# import matplotlib.pyplot as plt
# import seaborn as sns
# import sklearn.metrics as skm
# import sklearn.model_selection as skms
# import sklearn.linear_model as sklm
# import sklearn.svm as sksvm
# import sklearn.neighbors as skn
# import sklearn.ensemble as ske
# import sklearn.neural_network as sknn
# import sklearn.pipeline as skp
# import sklearn.compose as skc
# import sklearn.impute as ski
# import tensorflow._api.v2 as tfv2
# import tensorflow.keras as tk
# import tensorflow.keras.layers as tkl
# import tensorflow.keras.models as tkm
# import tensorflow.keras.utils as tku
# import tensorflow.keras.callbacks as tkc
# import tensorflow.keras.optimizers as tko
# from tensorflow.keras.models import load_model
# from tensorflow.keras.models import Sequential
# from tensorflow.keras.layers import Dense, LSTM as tklstm
# from tensorflow.keras.layers import Dropout as tkld
# from tensorflow.keras.layers import Activation as tkla
# from tensorflow.keras.layers import Flatten as tklf
# from tensorflow.keras.layers import Conv1D as tklc1d
# from tensorflow.keras.layers import MaxPooling1D as tklm1d
# from tensorflow.keras.layers import BatchNormalization as tklbn
# from tensorflow.keras.layers import LeakyReLU as tklr
# from tensorflow.keras.layers import Embedding as tkle
# from tensorflow.keras.layers import GlobalMaxPooling1D as tklgmp1d
# from tensorflow.keras.layers import GlobalAveragePooling1D as tklgap1d
# from tensorflow.keras.layers import Bidirectional as tklb
# from tensorflow.keras.layers import GRU as tklgru
# from tensorflow.keras.layers import SimpleRNN as tklsr
# from tensorflow.keras.layers import TimeDistributed as tkltd
# from tensorflow.keras.layers import RepeatVector as tklrv
# from tensorflow.keras.layers import Input as tkli

app = Flask(__name__)


@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json(force=True)
    symbol = data['symbol']
    model = load_model('models/'+symbol+'.h5')
    start = dt.datetime(2012, 1, 1)
    end = dt.datetime.now()
    df = web.DataReader(symbol, 'yahoo', start, end)
    data = df.filter(['Close'])
    dataset = data.values
    training_data_len = math.ceil(len(dataset)*0.8)
    scaler = skp.MinMaxScaler(feature_range=(0, 1))
    scaled_data = scaler.fit_transform(dataset)
    train_data = scaled_data[0:training_data_len, :]
    x_train = []
    y_train = []
    for i in range(60, len(train_data)):
        x_train.append(train_data[i-60:i, 0])
        y_train.append(train_data[i, 0])
    x_train, y_train = np.array(x_train), np.array(y_train)
    x_train = np.reshape(x_train, (x_train.shape[0], x_train.shape[1], 1))
    predictions = model.predict(x_train)
    predictions = scaler.inverse_transform(predictions)
    # train = data[:training_data_len]
    valid = data[training_data_len:]
    valid['Predictions'] = predictions
    return jsonify(valid.to_json())


if __name__ == '__main__':
    app.run(port=5000)

# Path: models/GOOG.h5
# Model: GOOG
# Date: 2021-02-01
# Epochs: 100
# Batch Size: 32
# LSTM: 50
# Dropout: 0.2
# Dense: 25
# Dense: 1
# Optimizer: adam
# Loss: mean_squared_error
# Metrics: accuracy
# Activation: relu
# Activation: linear
# Activation: sigmoid
# Activation: softmax
# Activation: tanh
# Activation: selu
# Activation: softplus
# Activation: softsign
# Activation: hard_sigmoid
# Activation: exponential
# Activation: linear
# Activation: relu
# Activation: softmax

# Path: models/AAPL.h5
# Model: AAPL
# Date: 2021-02-01
# Epochs: 100
# Batch Size: 32

# Path: models/MSFT.h5
# Model: MSFT
# Date: 2021-02-01

# Path: models/AMZN.h5
# Model: AMZN
# Date: 2021-02-01

# Path: models/FB.h5
# Model: FB
# Date: 2021-02-01

# Path: models/TSLA.h5
# Model: TSLA
# Date: 2021-02-01

# Path: models/NFLX.h5
# Model: NFLX
# Date: 2021-02-01

# Path: models/GOOGL.h5
# Model: GOOGL
# Date: 2021-02-01

# Path: models/GOOG.h5
# Model: GOOG
# Date: 2021-02-01
